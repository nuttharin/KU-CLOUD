<?php

namespace App\Repositories\TB_REGISTER_IOT_SERVICE;

interface RegisterIoTServiceRepository
{
    public function getAll();

    public function create($users, $iotservice_id);

    public function update(array $attr);

    public function delete($user_id, $register_iot_service);

    public function getEmailCustomerByIotServiceId($iotservice_id);
}
