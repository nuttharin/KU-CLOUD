<?php

namespace App\Repositories\Address;

interface AddressRepository
{
    public function getGeographies();

    public function getAllProvinces();

    public function getAllAmphures();

    public function getAmphuresByProvince($province_id);

    public function getAllDistricts();

    public function getDistrictsByAmphures($province_id, $amphure_id);

    public function createAddressUser(array  $attr);

}
