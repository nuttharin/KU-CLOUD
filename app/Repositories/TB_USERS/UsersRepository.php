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

    public  function getByTypeForAdmin($type);

    public  function getByTypeForCompany($type,$company_id);

    public  function countUserOnline($type,$company_id = null);

    public  function create(array $attributes);

    public  function update($id , array $attributes);

    public  function delete($id);
}