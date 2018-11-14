<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_REGISTER_WEBSERVICE extends Model
{
    //
    protected  $table = "TB_REGISTER_WEBSERVICE";
    protected $fillable = [
        'register_webservice_id','user_id',	'webservice_id'
    ];
}
