<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_STATIC extends Model
{
    protected $primaryKey = 'static_id';
    protected $table = "TB_STATIC";
    //
    protected $fillable = [
        'user_id', 'static_id', 'name', 'dashboard',
    ];

    protected $hidden = [

    ];

}
