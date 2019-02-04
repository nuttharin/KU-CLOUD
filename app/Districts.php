<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $primaryKey = 'district_id';
    protected $table = "Districts";

    protected $fillable = [
        'district_id', 'zip_code', 'name_th', 'name_en', 'amphure_id',
    ];

    public function getAmphure()
    {
        return $this->belongsTo("App\Amphures", "amphure_id");
    }
}
