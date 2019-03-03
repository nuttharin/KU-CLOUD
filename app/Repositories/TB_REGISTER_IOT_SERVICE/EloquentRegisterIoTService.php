<?php

namespace App\Repositories\TB_REGISTER_IOT_SERVICE;

use App\TB_REGISTER_IOT_SERVICE;
use App\TB_USERS;

class EloquentRegisterIoTService implements RegisterIoTServiceRepository
{
    public function getAll()
    {
        $data = TB_REGISTER_IOT_SERVICE::with(['user', 'iot_service'])->get();
        return \response()->json(compact('data'), 200);
    }

    public function create($users, $webservice_id)
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
                        'webservice_id' => $webservice_id,
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

    public function delete($user_id, $register_webservice_id)
    {
        TB_REGISTER_IOT_SERVICE::where([
            'user_id' => $user_id,
            'register_iot_service' => $register_webservice_id,
        ])->delete();
    }
}
