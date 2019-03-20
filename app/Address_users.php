<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address_users extends Model
{
    protected $primaryKey = 'address_id';
    protected $table = "ADDRESS_USERS";
    //
    protected $fillable = [
        'address_id', 'user_id', 'address_detail', 'district_id', 'amphure_id', 'province_id',
    ];

    protected $hidden = [

    ];

    public function getUser()
    {
        return $this->belongsTo("App\TB_USERS", "user_id");
    }

}
