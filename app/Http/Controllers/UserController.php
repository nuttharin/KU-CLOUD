<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function UserAdminister(Request $request)
    {
        $user = $request->session()->get('user');
        if (!$user->type_user == "ADMIN") {
            abort('403', "Sorry, You can do this actions");
        }
        return view('User.UserAdminister_Admin');
    }

    public function UserCompany(Request $request)
    {
        $user = $request->session()->get('user');
        if ($user->type_user === "COMPANY") {
            return view('User.UserCompany_Company');
        } else {
            return view('User.UserCompany_Admin');
        }
    }

    public function UserCustomer(Request $request)
    {
        $user = $request->session()->get('user');
        if ($user->type_user === "COMPANY") {
            return view('User.UserCustomer_Company');
        } else {
            return view('User.UserCustomer_Admin');
        }
    }

    public function ManageAccount()
    {
        return view('User.ManageAccount');
    }
}
