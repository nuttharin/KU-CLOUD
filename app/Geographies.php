<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geographies extends Model
{

    protected $primaryKey = 'user_id';
    protected $table = "Geographies";

    protected $fillable = [
        'geography_id', 'name',
    ];

    public function getProvinces()
    {
        return $this->hasMany('App\Provinces', 'geography_id');
    }
}
