<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amphures extends Model
{
    protected $primaryKey = 'amphure_id';
    protected $table = "Amphures";

    protected $fillable = [
        'amphure_id', 'code', 'name_th', 'name_en', 'province_id',
    ];

    public function getDistricts()
    {
        return $this->hasMany("App\Districts", "amphure_id");
    }

    public function getProvince()
    {
        return $this->belongsTo("App\Provinces", "province_id");
    }
}
