<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_COMPANY extends Model
{
    //
    protected  $table = "TB_COMPANY";
    protected $fillable = [
        'user_id', 'email_user'
    ];
}
