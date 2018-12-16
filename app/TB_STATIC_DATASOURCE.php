<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_STATIC_DATASOURCE extends Model
{
    protected $primaryKey = 'id';
    protected  $table = "TB_STATIC_DATASOURCE";
    //
    protected $fillable = [
        'id','static_id','name','webservice_id','body','headers'
    ];

    protected $hidden = [
        
    ];
}
