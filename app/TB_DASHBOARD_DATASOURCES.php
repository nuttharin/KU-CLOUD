<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_DASHBOARD_DATASOURCES extends Model
{
    protected $primaryKey = 'id';
    protected $table = "TB_DASHBOARD_DATASOURCES";
    //
    protected $fillable = [
        'id', 'dashboard_id', 'name', 'webservice_id', 'timeInterval', 'body', 'headers',
    ];

    protected $hidden = [

    ];
}
