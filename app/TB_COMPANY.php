<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_COMPANY extends Model
{
    //
    protected  $table = "TB_COMPANY";
    protected $fillable = [
        'company_id','company_name', 'alias', 'address', 'note','folder_log'
    ];
}
