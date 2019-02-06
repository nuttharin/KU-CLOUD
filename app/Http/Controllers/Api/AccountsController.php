<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Accounts\AccountsRepository;
use App\Repositories\Address\AddressRepository;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Image;
use Response;

class AccountsController extends Controller
{
    /**
     * @var AccountsRepository
     * @var AddressRepository
     */
    private $account;
    private $address;

    public function __construct(AccountsRepository $account, AddressRepository $address)
    {
//        if(!Gate::allows('isAdmin')){
        //            abort('403',"Sorry, You can do this actions");
        //        }
        $this->account = $account;
        $this->address = $address;
    }

    public function register(Request $request)
    {
        $attr = [
            'accountname' => $request->get('accountname'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => $request->get('password'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone')
        ];

        $user_id = $this->account->register($attr);

        if($request->get('checkbox_address') == 'true')
        {
            $attr = [
                'user_id' => $user_id,
                'address_detail' => $request->get('address_detail'),
                'district_id' => $request->get('district_id'),
                'amphure_id' => $request->get('amphure_id'),
                'province_id' => $request->get('province_id')
            ];

            $this->address->createAddressUser($attr);
        }

    }

    public function getAccount(Request $request)
    {
        $data = $this->account->getAccount(Auth::user()->user_id);
        return response()->json(compact('data'), 200);
    }

    public function getProfile($filename)
    {
        $path = storage_path('app/upload/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function uploadProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->get('imgProfile') != '') {
                if (Auth::user()->img_profile != 'default-profile.jpg') {
                    $path = storage_path('app/upload/' . Auth::user()->img_profile);
                    File::delete($path);
                }

                $data = $request->get('imgProfile');
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $imageName = str_random(10) . '.' . 'png';
                \File::put(storage_path() . '/app/upload/' . $imageName, $data);

                $img = Image::make(storage_path('app/upload/' . $imageName));
                $img->resize(400, 400);
                $img->save();

                $this->account->uploadProfile($imageName, Auth::user()->user_id);

            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(compact('image'), 200);
    }

    public function updateUsername(Request $request)
    {
        $this->account->updateUsername(Auth::user()->user_id, $request->get('username'));
    }

    public function updateName(Request $request)
    {
        $this->account->updateName(Auth::user()->user_id, $request->get('fname'), $request->get('lname'));
    }

    public function changePassword(Request $request)
    {
        return $this->account->changePassword($request->get('new_password'), $request->get('old_password'));
    }

    public function checkOldPassword(Request $request)
    {
        return $this->account->checkOldPassword($request->get('old_password'));
    }

    public function changePrimaryEmail(Request $request)
    {
        $this->account->changePrimaryEmail(Auth::user()->user_id, $request->get('email'));
    }

    public function addEmail(Request $request)
    {
        $this->account->addEmail(Auth::user()->user_id, $request->get('email'));
    }

    public function deleteEmail(Request $request)
    {
        $this->account->deleteEmail(Auth::user()->user_id, $request->get('email'));
    }

    public function changePrimaryPhone(Request $request)
    {
        $this->account->changePrimaryPhone(Auth::user()->user_id, $request->get('phone'));
    }

    public function addPhone(Request $request)
    {
        $this->account->addPhone(Auth::user()->user_id, $request->get('phone'));
    }

    public function deletePhone(Request $request)
    {
        $this->account->deletePhone(Auth::user()->user_id, $request->get('phone'));
    }
}
