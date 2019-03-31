<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_DATA_ANALYSIS extends Model
{

    protected $primaryKey = 'data_id';
    protected $table = "TB_DATA_ANALYSIS";

    protected $fillable = [
        'data_id', 'user_id', 'name', 'is_success', 'path_file', 'path_file_csv',
    ];
}
