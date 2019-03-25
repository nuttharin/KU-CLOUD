<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class TB_USERS extends Authenticatable implements JWTSubject
{

    protected $primaryKey = 'user_id';
    protected $table = "TB_USERS";
    //
    protected $fillable = [
        'user_id', 'username', 'district_id', 'fname', 'lname', 'password', 'type_user', 'block', 'online', 'img_profile',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['type_user' => $this->type_user];
    }

    public function email()
    {
        return $this->hasMany('App\TB_EMAIL', 'user_id');
    }

    public function phone()
    {
        return $this->hasMany('App\TB_PHONE', 'user_id');
    }

    public function user_company()
    {
        return $this->belongsTo("App\TB_USER_COMPANY", "user_id");
    }

    public function user_customer()
    {
        return $this->hasMany("App\TB_USER_CUSTOMER", "user_id");
    }

    public function getAddress()
    {
        return $this->hasMany("App\Address_users", "user_id");
    }

    public function checkFirstCreate()
    {
        return $this->hasOne("App\USER_FIRST_CREATE", "user_id");
    }

    public function getDashboards()
    {
        return $this->hasMany("App\TB_DASHBOARDS", "user_id");
    }

    public function webservices()
    {
        return $this->hasMany("App\TB_REGISTER_WEBSERVICE", "user_id");
    }

    public function iotservices()
    {
        return $this->hasMany("App\TB_REGISTER_IOT_SERVICE", "user_id");
    }
}
