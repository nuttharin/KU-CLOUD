<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Address\AddressRepository;

class AddressController extends Controller
{
    private $address;

    public function __construct(AddressRepository $address)
    {
        $this->address = $address;
    }

    public function getAllProvinces()
    {
        $data = $this->address->getAllProvinces();
        return response()->json(compact('data'), 200);
    }

    public function getAmphuresByProvince($province_id)
    {
        $data = $this->address->getAmphuresByProvince($province_id);
        return response()->json(compact('data'), 200);
    }

    public function getDistrictsByAmphures($province_id, $amphure_id)
    {
        $data = $this->address->getDistrictsByAmphures($province_id, $amphure_id);
        return response()->json(compact('data'), 200);
    }

}
