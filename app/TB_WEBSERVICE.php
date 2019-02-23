<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_WEBSERVICE extends Model
{
    //
    protected $primaryKey = 'webservice_id';
    protected  $table = "TB_WEBSERVICE";
    protected $fillable = [
        'webservice_id','company_id','service_name','service_name_DW','alias','URL','description','header_row','value_array','value_cal','value_groupby','status','update_time','create_at','updated_at'
    ];
}
