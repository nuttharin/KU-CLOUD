<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 10:19 AM
 */

namespace App\Repositories\TB_USERS;

interface UsersRepository
{
    public function getAll();

    public function getByTypeForAdmin($type);

    public function getByTypeForCompany($type, $company_id, $start, $length, $order, $dir);

    public function getCustomerByCompany();

    public function getAllEmailCustomer();

    public function getAllEmailCustomerInCompany();

    public function addCustomerInCompany(array $userList);

    public function searchByTypeForCompany($type, $company_id, $start, $length, $search, $order, $dir);

    public function countUserOnline($type, $company_id = null);

    public function countUser($type, $company_id);

    public function create(array $attributes);

    public function update(array $attributes);

    public function delete($id);

    public function deleteEmailUser(array $attributes);

    public function deletePhoneUser(array $attributes);

    //Custom function
    public function getTypeById($user_id);

    public function getCompanyIdByUserId($user_id);

    public function getUserById($user_id);

}
