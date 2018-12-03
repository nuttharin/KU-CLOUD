<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 11/30/2018
 * Time: 9:25 AM
 */

namespace App\Repositories\TB_WEBSERVICE;

use App\TB_WEBSERVICE;


class EloquentWebService implements  WebServiceRepository
{

    /**
     * @param $company_id
     */
    public function getWebServiceByCompany($company_id)
    {
        $data = TB_WEBSERVICE::where('company_id',$company_id)->get();
        return $data;
    }
}