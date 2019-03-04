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

    public function create(array $attr)
    {
        try {
            for ($i = 0; $i < sizeof($attr['users']); $i++) {
                $user = TB_USERS::where([
                    ['user_id', '=', $attr['users'][$i]],
                    ['type_user', '=', 'CUSTOMER'],
                ])->first();

                if (!empty($user)) {
                    TB_REGISTER_WEBSERVICE::create([
                        'user_id' => $attr['users'][$i],
                        'webservice_id' => $attr['webservice_id'],
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

    public function delete(array $attr)
    {
        TB_REGISTER_WEBSERVICE::where([
            'user_id' => $attr['user_id'],
            'register_webservice_id' => $attr['$register_webservice_id'],
        ])->delete();
    }
}
