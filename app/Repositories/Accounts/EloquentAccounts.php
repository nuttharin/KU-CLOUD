<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 1/5/2019
 * Time: 7:19 PM
 */

namespace App\Repositories\Accounts;

use App\Exceptions\CheckOldPasswordExceptions;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USERS;
use Auth;
use DB;
use Hash;

class EloquentAccounts implements AccountsRepository
{

    public function getAccount($user_id)
    {
        $user = TB_USERS::where('user_id', $user_id)->first();
        $data = [
            'username' => $user->username,
            'fname' => $user->fname,
            'lname' => $user->lname,
            'email' => TB_EMAIL::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
            'phone' => TB_PHONE::where('user_id', $user->user_id)->orderByRaw('is_primary DESC')->get(),
        ];
        return $data;
        // TODO: Implement getAccount() method.
    }

    public function uploadProfile($path, $user_id)
    {
        DB::beginTransaction();
        try {
            $user = TB_USERS::where('user_id', $user_id)->update(['img_profile' => $path]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function updateUsername($user_id, $username)
    {
        DB::beginTransaction();
        try {
            TB_USERS::where('user_id', $user_id)->update(
                [
                    'username' => $username,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function updateName($user_id, $fname, $lname)
    {
        DB::beginTransaction();
        try {
            TB_USERS::where('user_id', $user_id)->update(
                [
                    'fname' => $fname,
                    'lname' => $lname,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function changePassword($new_password, $old_password)
    {
        // TODO: Implement changePassword() method.
        DB::beginTransaction();
        try {
            if (Hash::check($old_password, Auth::user()->password)) {
                Auth::user()->password = Hash::make($new_password);
                Auth::user()->save();
            } else {
                throw new CheckOldPasswordExceptions();
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (CheckOldPasswordExceptions $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

    }

    public function checkOldPassword($old_password)
    {

    }

    public function changePrimaryEmail($user_id, $email_user)
    {
        DB::beginTransaction();
        try {
            TB_EMAIL::where([
                'user_id' => $user_id,
                'is_primary' => true,
            ])->update(['is_primary' => false]);

            TB_EMAIL::where([
                'user_id' => $user_id,
                'email_user' => $email_user,
            ])->update(['is_primary' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement changePrimaryEmail() method.
    }

    public function changePrimaryPhone($user_id, $phone_user)
    {
        DB::beginTransaction();
        try {
            TB_PHONE::where([
                'user_id' => $user_id,
                'is_primary' => true,
            ])->update(['is_primary' => false]);

            TB_PHONE::where([
                'user_id' => $user_id,
                'phone_user' => $phone_user,
            ])->update(['is_primary' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement changePrimaryPhone() method.
    }

    public function addEmail($user_id, $email_user)
    {
        DB::beginTransaction();
        try {
            TB_EMAIL::create([
                'user_id' => $user_id,
                'email_user' => $email_user,
                'is_verify' => false,
                'is_primary' => false,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement addEmail() method.
    }

    public function addPhone($user_id, $phone_user)
    {
        DB::beginTransaction();
        try {
            TB_PHONE::create([
                'user_id' => $user_id,
                'phone_user' => $phone_user,
                'is_verify' => false,
                'is_primary' => false,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement addPhone() method.
    }

    public function deleteEmail($user_id, $email_user)
    {
        DB::beginTransaction();
        try {
            $data = TB_EMAIL::where([
                ['user_id', '=', $user_id],
                ['email_user', '=', $email_user],
                ['is_primary', '=', false],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement deleteEmail() method.
    }

    public function deletePhone($user_id, $phone_user)
    {
        DB::beginTransaction();
        try {
            $data = TB_PHONE::where([
                ['user_id', '=', $user_id],
                ['phone_user', '=', $phone_user],
                ['is_primary', '=', false],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        // TODO: Implement deletePhone() method.
    }

    public function register(array $attr)
    {
        // TODO: Implement register() method.
        $user_id = null;
        DB::beginTransaction();
        try {
            $user = TB_USERS::create([
                'username' =>$attr['accountname'],
                'fname' => $attr['fname'],
                'lname' => $attr['lname'],
                'password' => Hash::make($attr['password']),
                'type_user' => 'CUSTOMER',
            ]);

            if ($user->user_id) {
                $user_id = $user->user_id;
                TB_PHONE::create([
                    'user_id' => $user->user_id,
                    'phone_user' => $attr['phone_user'],
                    'is_primary' => true,
                ]);

                TB_EMAIL::create([
                    'user_id' => $user->user_id,
                    'email_user' => $attr['email_user'],
                    'is_primary' => true,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $user_id;
    }
}
