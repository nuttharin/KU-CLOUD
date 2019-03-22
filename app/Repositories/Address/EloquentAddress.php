<?php

namespace App\Repositories\Address;

use App\Address_company;
use App\Address_users;
use App\Amphures;
use App\Districts;
use App\Geographies;
use App\Provinces;

class EloquentAddress implements AddressRepository
{
    public function getGeographies()
    {
        $geographies = Geographies::all();
        return $geographies;
    }

    public function getAllProvinces()
    {
        $provinces = Provinces::orderBy('name_th')->get();
        return $provinces;
    }

    public function getAllAmphures()
    {
        $amphures = Amphures::orderBy('name_th')->get();
        return $amphures;
    }

    public function getAmphuresByProvince($province_id)
    {
        $amphures = Provinces::where('province_id', $province_id)
            ->first()
            ->getAmphures()
            ->orderBy('name_th')
            ->get();
        return $amphures;
    }

    public function getAllDistricts()
    {
        $districts = Districts::orderBy('name_th')->get();
        return $districts;
    }

    public function getDistrictsByAmphures($province_id, $amphure_id)
    {
        $districts = Amphures::where([
            ['Amphures.province_id', '=', $province_id],
            ['Amphures.amphure_id', '=', $amphure_id],
        ])
            ->join('Districts', 'Districts.amphure_id', '=', 'Amphures.amphure_id')
            ->orderBy('Districts.name_th')
            ->get();
        return $districts;
    }

    public function createAddressUser(array $attr)
    {
        Address_users::insert($attr);
    }

    public function createAddressCompany(array $attr)
    {
        Address_company::insert($attr);
    }
}
