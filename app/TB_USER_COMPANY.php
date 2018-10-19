<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_USER_COMPANY extends Model
{
    protected $primaryKey = 'user_id';
    protected  $table = "TB_USER_COMPANY";
    //
    protected $fillable = [
        'user_id', 'company_id','sub_type_user'
    ];

    public function TB_USERS(){
        return $this->hasMany('App\TB_USERS','user_id');
    }
}
