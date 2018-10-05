<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class TB_USERS extends Authenticatable implements JWTSubject
{
    
    protected $primaryKey = 'user_id';
    protected  $table = "TB_USERS";
    //
    protected $fillable = [
        'fname','lname','password','type_user'
    ];

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [ 'type_user' => $this->type_user ];
    }

    public function phone(){
        return $this->hasMany('App\TB_PHONE','user_id');
    }
}
