<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogViewer\LogViewer;
use Cookie;
use DB;
use Gate;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index')->with('user', Auth::user());
    }

    public function Infographic()
    {
        return view('customer.index')->with('user', Auth::user());
    }
}
