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
        return $this->register->create($request->get('users'), $request->get('webservice_id'));
    }

    public function getAllRegisterWebservice()
    {
        return $this->register->getAll();
    }

    public function deleteRegister(Request $request)
    {
        return $this->register->delete($request->get('user_id'), $request->get('register_webservice_id'));
    }
}
