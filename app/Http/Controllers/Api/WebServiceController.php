<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;

class WebServiceController extends Controller
{
    public function __construct(WebServiceRepository $webservice)
    {
        // if (!Gate::allows('isCustomer')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->webservice = $webservice;
    }

    public function getWebServiceByCompany()
    {
        return $this->webservice->getWebServiceByCompany();
    }

}
