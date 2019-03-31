<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_DASHBOARDS extends Model
{
    protected $primaryKey = 'dashboard_id';
    protected $table = "TB_DASHBOARDS";
    //
    protected $fillable = [
        'user_id', 'dashboard_id', 'name', 'dashboard', 'description', 'is_public', 'update_by',
    ];

    protected $hidden = [

    ];
}
