<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ApproveCompany;
use App\Repositories\TB_COMPANY\CompanyRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{

    private $company;

    public function __construct(CompanyRepository $company)
    {
        if (!Gate::allows('isCustomer')) {
            abort('403', "Sorry, You can do this actions");
        }

        $this->company = $company;
        $this->auth = Auth::user();
    }

    public function getCompanyListForCustomer()
    {
        $data = $this->company->getCompanyListForCustomer();
        return response()->json(compact('data'), 200);
    }

    public function approveCompany(ApproveCompany $request)
    {
        $this->company->approveCompany($request->get('company_id'));
    }
    public function getAllWebserviceData_customer(Request $request)
    {
        // $token = $request->bearerToken();
        // $payload = JWTAuth::setToken($token)->getPayload();
        //$companyID = Auth::user()->user_company()->first()->company_id;
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.status,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE (TB_WEBSERVICE.status='Private Company' or TB_WEBSERVICE.status='Public') and TB_WEBSERVICE.company_id='2'");

        if (empty($webService)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('webService'), 200);
    }
}
