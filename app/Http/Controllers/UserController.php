<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function UserAdminister()
    {
        if (!Gate::allows('isAdmin')) {
            abort('403', "Sorry, You can do this actions");
        }
        return view('User.UserAdminister_Admin')->with('user', Auth::user());
    }

    public function UserCompany()
    {
        if (Auth::user()->type_user === "COMPANY") {
            return view('User.UserCompany_Company')->with('user', Auth::user());
        } else {
            return view('User.UserCompany_Admin')->with('user', Auth::user());
        }
    }

    public function UserCustomer()
    {
        if (Auth::user()->type_user === "COMPANY") {
            return view('User.UserCustomer_Company')->with('user', Auth::user());
        } else {
            return view('User.UserCustomer_Admin')->with('user', Auth::user());
        }
    }
}
