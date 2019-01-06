<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Accounts\AccountsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

use App\TB_USERS;
use File;
use Response;

use Auth;

class AccountsController extends Controller
{
    /**
     * @var AccountsRepository
     */
    private $account;

    public  function __construct(AccountsRepository $account)
    {
//        if(!Gate::allows('isAdmin')){
//            abort('403',"Sorry, You can do this actions");
//        }
        $this->account = $account;
    }

    public function getAccount(Request $request){
        $data = $this->account->getAccount(Auth::user()->user_id);
        return response()->json(compact('data'),200);
    }

    public function getProfile($filename){
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

    public function uploadProfile(Request $request){
        if ($request->hasFile('img-profile')) {
            if(Auth::user()->img_profile != 'default-profile.jpg'){
                $path =  storage_path('app/upload/' . Auth::user()->img_profile);
                File::delete($path);
            }
            $path = $request->file('img-profile')->store('upload');
            $this->account->uploadProfile(str_replace('upload/','',$path),Auth::user()->user_id);
            return response()->json(compact('image'),200);
        }
    }

    public function changePrimaryEmail(Request $request){
        $this->account->changePrimaryEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function addEmail(Request $request){
        $this->account->addEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function deleteEmail(Request $request){
        $this->account->deleteEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function changePrimaryPhone(Request $request){
        $this->account->changePrimaryPhone(Auth::user()->user_id,$request->get('phone'));
    }

    public function addPhone(Request $request){
        $this->account->addPhone(Auth::user()->user_id,$request->get('phone'));
    }

    public function deletePhone(Request $request){
        $this->account->deletePhone(Auth::user()->user_id,$request->get('phone'));
    }
}
