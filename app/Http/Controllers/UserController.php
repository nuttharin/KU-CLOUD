<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function UserCompany()
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('404', "Sorry, You can do this actions");
        }
        return view('User.UserCompany')->with('user', Auth::user());
    }

    public function UserCustomer()
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('404', "Sorry, You can do this actions");
        }
        return view('User.UserCustomer')->with('user', Auth::user());
    }
}
