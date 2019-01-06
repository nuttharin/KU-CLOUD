<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 1/5/2019
 * Time: 7:20 PM
 */

namespace App\Repositories\Accounts;


interface AccountsRepository
{

    public function getAccount($user_id);

    public function uploadProfile($path,$user_id);

    public function changePassword($newPassword,$user_id);

    public function changePrimaryEmail($user_id,$email_user);

    public function changePrimaryPhone($user_id,$phone_user);

    public function addEmail($user_id,$email_user);

    public function addPhone($user_id,$phone_user);

    public function deleteEmail($user_id,$email_user);

    public function deletePhone($user_id,$phone_user);

}