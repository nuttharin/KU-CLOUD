<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_INFOGRAPHIC extends Model
{
    protected $primaryKey = 'info_id';
    protected  $table = "TB_INFOGRAPHIC";
    //
    protected $fillable = [
        'info_id', 'user_id', 'name', 'info_data', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        
    ];

}
