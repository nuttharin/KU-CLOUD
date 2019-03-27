<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address_company extends Model
{
    protected $primaryKey = 'address_id';
    protected $table = "ADDRESS_COMPANY";
    //
    protected $fillable = [
        'address_id', 'company_id', 'address_detail', 'district_id', 'amphure_id', 'province_id',
    ];

    protected $hidden = [

    ];

}
