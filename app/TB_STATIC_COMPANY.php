<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_STATIC_COMPANY extends Model
{
    protected $primaryKey = 'id';
    protected  $table = "TB_STATIC_COMPANY";
    //
    protected $fillable = [
        'static_id','company_id',
    ];

    protected $hidden = [
        
    ];
}
