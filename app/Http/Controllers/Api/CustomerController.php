<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_COMPANY\CompanyRepository;
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

    public function approveCompany(Request $request)
    {
        $this->company->approveCompany($request->get('company_id'));
    }
}
