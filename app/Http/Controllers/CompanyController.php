<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Gate;

use Log;

use App\LogViewer\LogViewer;

class CompanyController extends Controller
{
    
    public function index()
    {       
        return view('company.index');
    }

    public function user()
    {
        if(!Gate::allows('isCompanyAdmin')){
            abort('404',"Sorry, You can do this actions");
        }
        return view('company.user')->with('user', Auth::user());
    }
    
    public function customer()
    {
        return view('company.customer')->with('user', Auth::user());
    }

    public function infographic()
    {
        return view('company.infographic');
    }

    public function static()
    {
        return view('company.static')->with('user', Auth::user());
    }

    public function service()
    {
        return view('company.service')->with('user', Auth::user());
    }

    public function Add_service()
    {
        return view('company.add_webService')->with('user', Auth::user());
    }
    
    public function Show_service()
    {
        return view('company.showService')->with('user', Auth::user());
    }

    public  function LogViewer()
    {
        return view('company.LogViewer')->with('user', Auth::user());
    }
}
