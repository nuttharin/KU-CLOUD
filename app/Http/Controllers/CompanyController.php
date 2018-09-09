<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
