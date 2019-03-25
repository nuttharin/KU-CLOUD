<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_REGISTER_WEBSERVICE\RegisterWebserviceRepository;
use Illuminate\Http\Request;

class RegisterWebserviceController extends Controller
{
    public function __construct(RegisterWebserviceRepository $register)
    {
        // if (!Gate::allows('isCustomer')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->register = $register;
    }

    public function createRegister(Request $request)
    {
        $attr = [
            'users' => $request->get('users'),
            'webservice_id' => $request->get('webservice_id'),
        ];
        return $this->register->create($attr);
    }

    public function getAllRegisterWebservice()
    {
        return $this->register->getAll();
    }

    public function deleteRegister(Request $request)
    {
        $attr = [
            'user_id' => $request->get('user_id'),
            'register_webservice_id' => $request->get('register_webservice_id'),
        ];
        return $this->register->delete($attr);
    }

    public function getEmailCustomerByWebserviceId($webservice_id)
    {
        $data = $this->register->getEmailCustomerByWebserviceId($webservice_id);
        return response()->json(\compact('data'), 200);
    }
}
