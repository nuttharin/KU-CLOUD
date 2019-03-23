<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_REGISTER_IOT_SERVICE\RegisterIoTServiceRepository;
use Illuminate\Http\Request;

class RegisterIoTServiceController extends Controller
{
    public function __construct(RegisterIoTServiceRepository $register)
    {
        // if (!Gate::allows('isCustomer')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->register = $register;
    }

    public function createRegister(Request $request)
    {
        return $this->register->create($request->get('users'), $request->get('iotservice_id'));
    }

    public function getAllRegister()
    {
        return $this->register->getAll();
    }

    public function deleteRegister(Request $request)
    {
        return $this->register->delete($request->get('user_id'), $request->get('register_iot_service'));
    }

    public function getEmailCustomerByIotServiceId($iotservice_id)
    {
        $data = $this->register->getEmailCustomerByIotServiceId($iotservice_id);
        return response()->json(\compact('data'), 200);
    }
}
