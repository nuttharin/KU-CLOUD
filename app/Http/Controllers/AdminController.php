<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function user()
    {
        return view('admin.user');
    }
    public function company()
    {
        return view('admin.company');
    }
    public function customer()
    {
        return view('admin.customer');
    }
    public function administer()
    {
        return view('admin.administer');
    }
    public function static()
    {
        return view('admin.static');
    }
}
