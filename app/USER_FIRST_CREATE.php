<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USER_FIRST_CREATE extends Model
{
    protected $primaryKey = 'id';
    protected $table = "USER_FIRST_CREATE";
    //
    protected $fillable = [
        'user_id', 'token',
    ];

    public function getUser()
    {
        return $this->belongsTo("App\TB_USERS", "user_id");
    }
}
