<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_INFO_DATASOURCE extends Model
{
    protected $primaryKey = 'id';
    protected  $table = "TB_INFO_DATASOURCE";
    //
    protected $fillable = [
        'id','info_id','name','webservice_id','timeInterval','body','headers'
    ];

    protected $hidden = [
        
    ];
}
