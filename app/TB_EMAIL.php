<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_EMAIL extends Model
{
    //    
    protected $primaryKey = 'user_id';
    protected  $table = "TB_EMAIL";
    //
    protected $fillable = [
        'user_id', 'email_user','is_verify'
    ];
}
