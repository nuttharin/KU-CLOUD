<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{

    protected $primaryKey = 'province_id';
    protected $table = "PROVINCES";

    protected $fillable = [
        'province_id', 'code', 'name_th', 'name_en', 'geography_id',
    ];

    public function getAmphures()
    {
        return $this->hasMany("App\Amphures", "province_id");
    }

    public function getGeography()
    {
        return $this->belongsTo("App\Geographies", "geography_id");
    }
}
