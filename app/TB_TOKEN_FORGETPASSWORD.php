<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_TOKEN_FORGETPASSWORD extends Model
{
    protected $primaryKey = 'id';
    protected  $table = "TB_TOKEN_FORGETPASSWORD";
    //
    protected $fillable = [
        'id','user_id','token'
    ];

    protected $hidden = [
        
    ];
}
