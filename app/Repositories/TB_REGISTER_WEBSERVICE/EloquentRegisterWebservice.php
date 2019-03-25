<?php

namespace App\Repositories\TB_REGISTER_WEBSERVICE;

use App\TB_REGISTER_WEBSERVICE;
use App\TB_USERS;
use Illuminate\Support\Facades\Auth;

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
            'register_webservice_id' => $attr['register_webservice_id'],
        ])->delete();
    }

    public function getEmailCustomerByWebserviceId($webservice_id)
    {
        $data = TB_USERS::where([
            ['type_user', '=', 'CUSTOMER'],
            ['company_id', '=', Auth::user()->user_company()->first()->company_id],
        ])
            ->join('TB_EMAIL', 'TB_EMAIL.user_id', '=', 'TB_USERS.user_id')
            ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.user_id', '=', 'TB_USERS.user_id')
            ->whereNotIn('TB_USERS.user_id', function ($query) use ($webservice_id) {
                $query->select('user_id')
                    ->from('TB_REGISTER_WEBSERVICE')
                    ->where('webservice_id', '=', $webservice_id);
            })->get(['TB_EMAIL.user_id', 'TB_EMAIL.email_user']);
        return $data;
    }
}
