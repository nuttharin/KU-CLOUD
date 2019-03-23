<?php

namespace App\Repositories\TB_REGISTER_WEBSERVICE;

interface RegisterWebserviceRepository
{
    public function getAll();

    public function create(array $attr);

    public function update(array $attr);

    public function delete(array $attr);

    public function getEmailCustomerByWebserviceId($webservice_id);
}
