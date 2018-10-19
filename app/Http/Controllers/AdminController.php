<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function UsersAdminister()
    {
        return view('admin.UsersAdminister');
    }
    public function UsersCompany()
    {
        return view('admin.UsersCompany');
    }
    public function UsersCustomer()
    {
        return view('admin.UsersCustomer');
    }
    public function Company()
    {
        return view('admin.Company');
    }
    public function Static()
    {
        return view('admin.Static');
    }
}
