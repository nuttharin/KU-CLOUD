<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 11/30/2018
 * Time: 9:25 AM
 */

namespace App\Repositories\TB_WEBSERVICE;

use App\TB_WEBSERVICE;
use App\TB_IOTSERVICE;
use Auth;

class EloquentWebService implements WebServiceRepository
{

    public function getWebServiceByCompany()
    {
        $data = TB_WEBSERVICE::where('company_id', Auth::user()->user_company()->first()->company_id)->get();
        return \response()->json(compact('data'), 200);
    }

    public function getServiceByCompany()
    {
        $data = [];
        $data = [ 
            'webservice' => TB_WEBSERVICE::where('company_id', Auth::user()->user_company()->first()->company_id)->get(),
            'iotservice' => TB_IOTSERVICE::where('company_id', Auth::user()->user_company()->first()->company_id)->get(),
        ];
            
        return response()->json(compact('data'), 200);
    }
}
