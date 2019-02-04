<?php

namespace App\Repositories\Address;

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
        $provinces = Provinces::all();
        return $provinces;
    }

    public function getAllAmphures()
    {
        $amphures = Amphures::all();
        return $amphures;
    }

    public function getAmphuresByProvince($province_id)
    {
        $amphures = Provinces::where('province_id', $province_id)
            ->first()
            ->getAmphures()
           
            ->get();
        return $amphures;
    }

    public function getAllDistricts()
    {
        $districts = Districts::all();
        return $districts;
    }

    public function getDistrictsByAmphures($province_id, $amphure_id)
    {
        $districts = Amphures::where([
            ['Amphures.province_id', '=', $province_id],
            ['Amphures.amphure_id', '=', $amphure_id],
        ])
            ->join('Districts', 'Districts.amphure_id', '=', 'Amphures.amphure_id')
            ->get();
        return $districts;
    }
}
