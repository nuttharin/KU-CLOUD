<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USER_VERIFICATIONS extends Model
{
    protected $primaryKey = 'id';
    protected  $table = "USER_VERIFICATIONS";
    //
    protected $fillable = [
        'user_id','token'
    ];
    
}
