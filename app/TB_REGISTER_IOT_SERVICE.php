<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_REGISTER_IOT_SERVICE extends Model
{
    //
    protected $table = "TB_REGISTER_IOT_SERVICE";
    protected $fillable = [
        'register_iot_service', 'user_id', 'iotservice_id',
    ];

    public function iot_service()
    {
        return $this->belongsTo('App\TB_IOTSERVICE', 'iotservice_id');
    }

    public function user()
    {
        return $this->belongsTo('App\TB_USERS', 'user_id');
    }
}
