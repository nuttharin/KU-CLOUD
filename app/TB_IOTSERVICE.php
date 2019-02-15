<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_IOTSERVICE extends Model
{
    //
    protected $primaryKey = 'iotservice_id';
    protected  $table = "TB_IOTSERVICE";
    protected $fillable = [
        'iotservice_id','company_id','iot_name','iot_name_DW','alias','API','description','value_cal','status','create_at','updated_at'
    ];
}
