<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TB_COMPANY extends Model
{
    //
    protected $primaryKey = 'company_id';
    protected $table = "TB_COMPANY";
    protected $fillable = [
        'company_id', 'company_name', 'alias', 'address', 'note', 'folder_log','img_logo',
    ];

    public function webservices()
    {
        return $this->hasMany('App\TB_WEBSERVICE', 'company_id');
    }
}
