<?php

namespace App\Repositories\TB_REGISTER_WEBSERVICE;

use App\TB_REGISTER_WEBSERVICE;
use App\TB_USERS;

class EloquentRegisterWebservice implements RegisterWebserviceRepository
{
    public function getAll()
    {
        $data = TB_REGISTER_WEBSERVICE::with(['user', 'webservice'])->get();
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
                    TB_REGISTER_WEBSERVICE::create([
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
        TB_REGISTER_WEBSERVICE::where([
            'user_id' => $user_id,
            'register_webservice_id' => $register_webservice_id,
        ])->delete();
    }
}
