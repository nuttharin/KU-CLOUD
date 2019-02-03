<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_USER_CUSTOMER extends Model
{
    //
    protected $table = "TB_USER_CUSTOMER";

    protected $fillable = [
        'user_id', 'company_id', 'is_approved',
    ];

    public function TB_USERS()
    {
        return $this->belongsTo('App\TB_USERS', 'user_id');
    }
}
