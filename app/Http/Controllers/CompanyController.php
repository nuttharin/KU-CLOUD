<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Gate;
use Cookie;
use DB;
use Log;

use App\LogViewer\LogViewer;
use App\TB_WEBSERVICE;
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

    public function manageAccounts()
    {
        return view('company.manageAccounts')->with('user', Auth::user());
    }
    
    public function customer()
    {
        return view('company.customer')->with('user', Auth::user());
    }

    public function infographic()
    {
        return view('company.infographic')->with('user', Auth::user());
    }

    public function staticDatatable(){
        return view('company.staticDataTable')->with('user',Auth::user());
    }

    public function static($id)
    {
        return view('company.static')
        ->with('id',$id)
        ->with('user', Auth::user());
    }

    public function service()
    {
        return view('company.service')->with('user', Auth::user());
    }

    public function Add_service()
    {
        return view('company.add_webService')->with('user', Auth::user());
    }

    public function Output_service()
    {
        return view('company.outputService')->with('user',Auth::user());
    }    
    
    public function Show_service()
    {
        return view('company.showService')->with('user', Auth::user());
    }

    public  function LogViewer()
    {
        return view('company.LogViewer')->with('user', Auth::user());
    }

    public function Logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return view('auth.index')->withCookie(Cookie::forget('token'));
    }

    public function test()
    {
        return view('company.test')->with('user', Auth::user());
    }
    public function EditService($id)
    {
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE TB_WEBSERVICE.webservice_id='$id'");
        return view('company.edit_webService')
        ->with('user',Auth::user())
        ->with('webService',$webService);
    }
}
