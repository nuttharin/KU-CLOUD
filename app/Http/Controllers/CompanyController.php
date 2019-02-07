<?php

namespace App\Http\Controllers;

use App\LogViewer\LogViewer;
use App\Weka\Clusterers\Association;
use App\Weka\Clusterers\SimpleKMeans;
use DB;
use Gate;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{

    public function index()
    {
        return view('company.index');
    }

    public function user()
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('404', "Sorry, You can do this actions");
        }
        return view('company.user')->with('user', Auth::user());
    }

    public function manageAccounts()
    {
        return view('company.manageAccounts')->with('user', Auth::user());
    }

    public function customer()
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('404', "Sorry, You can do this actions");
        }
        return view('company.customer')->with('user', Auth::user());
    }

    public function infographic()
    {
        return view('company.infographic')->with('user', Auth::user());
    }

    public function staticDatatable()
    {
        return view('company.staticDataTable')->with('user', Auth::user());
    }

    function static($id) {
        return view('company.static')
            ->with('id', $id)
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
        return view('company.outputService')->with('user', Auth::user());
    }

    public function Show_service()
    {
        return view('company.showService')->with('user', Auth::user());
    }

    public function Iot()
    {
        return view('company.iot')->with('user', Auth::user());
    }

    public function Add_iot()
    {
        return view('company.add_iot')->with('user', Auth::user());
    }

    public function LogViewer()
    {
        return view('company.LogViewer')->with('user', Auth::user());
    }

    public function Logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function test()
    {
        $pathWekaLib = config('app.weka_lib');
        $pathWekaInput = config('app.weka_input');

        $cmd = "java -cp " . $pathWekaLib . " weka.clusterers.SimpleKMeans -N 2 -t " . $pathWekaInput . "glass.arff";
        //$cmd = "java -cp " . $pathWekaLib . " weka.core.Instances " . $pathWekaInput . "attempt1.arff";
        exec($cmd, $output);
        dd($cmd);
        $simpleKMeans = new SimpleKMeans();
        $data = $simpleKMeans->getSimpleKMeansToJson($output);
        //echo $data;

        // $t = new ConvertJsonToArff();
        // $t->convertToAttr();

        return view('company.test')
            ->with('user', Auth::user())
            ->with('output', $output);
    }

    public function testAsso()
    {
        $pathWekaLib = config('app.weka_lib');
        $pathWekaInput = config('app.weka_input');

        $cmd = "java -cp " . $pathWekaLib . " weka.associations.Apriori -N 10 -t " . $pathWekaInput . "vote.arff";
        exec($cmd, $output);
        dd($cmd);
        $asso = new Association();
        $data = $asso->getAssociationJsonFormat($output);
        echo $data;
        // $simpleKMeans = new SimpleKMeans();
        // $data = $simpleKMeans->getSimpleKMeansToJson($output);
        // echo $data;
        // return view('company.test')
        //     ->with('user', Auth::user())
        //     ->with('output', $output);
    }

    public function EditService($id)
    {
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE TB_WEBSERVICE.webservice_id='$id'");
        return view('company.edit_webService')
            ->with('user', Auth::user())
            ->with('webService', $webService);
    }

    //Weka

    public function AnalysisPrepareData()
    {
        return view('company.AnalysisPrepareData')->with('user', Auth::user());
    }

    public function DataAnalysis()
    {
        return view('company.DataAnalysis')->with('user', Auth::user());
    }
}
