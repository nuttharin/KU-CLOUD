<?php

namespace App\Http\Controllers;

use Gate;

class CustomerController extends Controller
{
    public function __construct()
    {
        if (!Gate::allows('isCustomer')) {
            abort('403', "Sorry, You can do this actions");
        }
    }

    public function Index()
    {
        return view('Customer.Index');
    }

    public function ManageCompany()
    {
        return view('Customer.ManageCompany');
    }

    public function ManageAccounts()
    {
        return view('Customer.ManageAccounts');
    }

    public function Infographic()
    {
        return view('customer.index');
    }
    public function Output_service()
    {
        return view('customer.outputService');
    }
}
