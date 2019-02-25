<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_IOTSERVICE extends Model
{
    //
    protected $primaryKey = 'iotservice_id';
    protected  $table = "TB_IOTSERVICE";
    protected $fillable = [
        'iotservice_id','company_id','iot_name','iot_name_DW','type','alias','API','description','status','pins_onoff','url_onoff_input','url_onoff_output','dataformat','value_cal','value_gropby','updatetime_input'
    ];
}
