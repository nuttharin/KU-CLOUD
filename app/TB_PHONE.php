<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_PHONE extends Model
{
    //
    protected $primaryKey = 'user_id';
    protected  $table = "TB_PHONE";

    protected $fillable = [
        'phone_user','user_id','is_verify','is_primary'
    ];

    public function TB_USRES(){
        return $this->belongsTo("App\TB_USERS","user_id");
    }
}
