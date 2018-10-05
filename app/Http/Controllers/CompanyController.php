<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        
        return view('company.index');
    }

    public function user()
    {
        return view('company.user');
    }   

    public function static()
    {
        return view('company.static');
    }
    public function service()
    {
        return view('company.service');
    }
    public function Add_service()
    {
        return view('company.add_webService');
    }
    public function Show_service()
    {
        return view('company.showService');
    }
}
