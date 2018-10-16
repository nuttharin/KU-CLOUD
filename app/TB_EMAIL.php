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

    public function TB_USERS() {
        return $this->belongsTo("App\TB_USERS","user_id");
    }
}
