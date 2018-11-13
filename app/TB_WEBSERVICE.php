<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_WEBSERVICE extends Model
{
    //
    protected  $table = "TB_WEBSERVICE";
    protected $fillable = [
        'webservice_id','service_name',	'alias','URL','description','header_row','modify_date'
    ];
}
