<?php

namespace App\Repositories\TB_REGISTER_IOT_SERVICE;

use App\TB_REGISTER_IOT_SERVICE;
use App\TB_USERS;
use Illuminate\Support\Facades\Auth;

class EloquentRegisterIoTService implements RegisterIoTServiceRepository
{
    public function getAll()
    {
        $data = TB_REGISTER_IOT_SERVICE::with(['user', 'iot_service'])->get();
        return \response()->json(compact('data'), 200);
    }

    public function create($users, $iotservice_id)
    {
        try {
            for ($i = 0; $i < sizeof($users); $i++) {
                $user = TB_USERS::where([
                    ['user_id', '=', $users[$i]],
                    ['type_user', '=', 'CUSTOMER'],
                ])->first();

                if (!empty($user)) {
                    TB_REGISTER_IOT_SERVICE::create([
                        'user_id' => $users[$i],
                        'iotservice_id' => $iotservice_id,
                    ]);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(array $attr)
    {

    }

    public function delete($user_id, $register_iot_service)
    {
        TB_REGISTER_IOT_SERVICE::where([
            'user_id' => $user_id,
            'register_iot_service' => $register_iot_service,
        ])->delete();
    }

    public function getEmailCustomerByIotServiceId($iotservice_id)
    {
        $data = TB_USERS::where([
            ['type_user', '=', 'CUSTOMER'],
            ['company_id', '=', Auth::user()->user_company()->first()->company_id],
        ])
            ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
            ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
            ->whereNotIn('TB_USERS.user_id', function ($query) use ($iotservice_id) {
                $query->select('user_id')
                    ->from('TB_REGISTER_IOT_SERVICE')
                    ->where('iotservice_id', '=', $iotservice_id);
            })->get(['TB_EMAIL.user_id', 'TB_EMAIL.email_user']);
        return $data;
    }
}
