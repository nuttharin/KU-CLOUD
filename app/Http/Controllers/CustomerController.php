<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Support\Facades\Auth;

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
        return view('Customer.Index')->with('user', Auth::user());
    }

    public function ManageCompany(){
         return view('Customer.ManageCompany')->with('user', Auth::user());
    }

    public function ManageAccounts()
    {
        return view('Customer.ManageAccounts')->with('user', Auth::user());
    }

    public function Infographic()
    {
        return view('customer.index')->with('user', Auth::user());
    }
}
