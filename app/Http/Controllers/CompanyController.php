<?php

namespace App\Http\Controllers;

use App\LogViewer\LogViewer;
use App\Weka\Classify\J48;
use App\Weka\Classify\SimpleLinearRegression;
use App\Weka\Clusterers\Association;
use App\Weka\Clusterers\SimpleKMeans;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    public function ManageCompanyMe()
    {
        return view('Company1.ManageCompanyMe');
    }

    public function Index()
    {
        return view('Company1.Index')->with('user', Auth::user());
    }

    public function manageAccounts()
    {
        return view('company.manageAccounts')->with('user', Auth::user());
    }

    public function infographic()
    {
        return view('company.infographic')->with('user', Auth::user());
    }

    public function service()
    {
        return view('company.service')->with('user', Auth::user());
    }

    public function Add_service()
    {
        return view('company.add_webService')->with('user', Auth::user());
    }

    public function Add_service_General()
    {
        return view('company.add_webService_General')->with('user', Auth::user());
    }

    public function Output_service()
    {
        return view('company.outputService')->with('user', Auth::user());
    }

    public function Show_service()
    {
        return view('company.showService')->with('user', Auth::user());
    }

    // public function Iot()
    // {
    //     return view('company.iot')->with('user', Auth::user());
    // }

    public function Add_InputIot()
    {
        return view('company.add_InputIot')->with('user', Auth::user());
    }

    public function Add_OutputIot()
    {
        return view('company.add_OutputIot')->with('user', Auth::user());
    }

    public function LogViewer()
    {
        return view('company.LogViewer')->with('user', Auth::user());
    }

    public function Logout(Request $request)
    {
        try {
            $request->session()->forget('user');
            $request->session()->forget('token_exp');
            $token = $request->cookie('token');
            if (!empty($token)) {
                $logoutRequest = Request::create(
                    env('API_URL') . 'Auth/Logout',
                    'POST'
                );
                $response = Route::dispatch($logoutRequest);
                Cookie::queue(Cookie::forget('token', '/', config('IP_ADDRESS')));

            }

            Cookie::queue(Cookie::forget('socket_token', '/', config('IP_ADDRESS')));
            Cookie::queue(Cookie::forget('io', '/', config('IP_ADDRESS')));
            // JWTAuth::invalidate(JWTAuth::parseToken());
            return redirect('/');
        } catch (Exception $e) {
            return redirect('/');
        }

        // $tokenRequest = Request::create(
        //     env('APP_URL') . '/api/Auth/Logout',
        //     'POST'
        // );

        // $response = Route::dispatch($tokenRequest);

        // if ($response->getStatusCode() == 200) {
        //     $data = json_decode($response->getContent());

        //     return redirect('/');
        //     // return redirect('/User/Company')->cookie(
        //     //     'access_token', //name
        //     //     $data->token, //value
        //     //     true// HttpsOnly
        //     // );
        // }
        // // config([
        // //     'jwt.blacklist_enabled' => true,
        // // ]);
        // auth()->logout();
        // Cookie::queue(Cookie::forget('token', '/', 'localhost'));
        // //JWTAuth::invalidate(JWTAuth::parseToken());

    }

    public function test()
    {
        $pathWekaLib = config('app.weka_lib');
        $pathWekaInput = config('app.weka_input');

        $cmd = "java -cp " . $pathWekaLib . " weka.clusterers.SimpleKMeans -N 2 -t " . $pathWekaInput . "glass.arff";
        //$cmd = "java -cp " . $pathWekaLib . " weka.core.Instances " . $pathWekaInput . "attempt1.arff";
        exec($cmd, $output);
        $simpleKMeans = new SimpleKMeans();
        $data = $simpleKMeans->getSimpleKMeansToJson($output);
        dd($data);

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
        dd($output);
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

    public function testClassi()
    {
        $pathWekaLib = config('app.weka_lib');
        $pathWekaInput = config('app.weka_input');

        $cmd = "java -cp " . $pathWekaLib . " weka.classifiers.trees.J48 -v -t " . $pathWekaInput . "glass.arff";
        exec($cmd, $output);

        //dd($output);

        $classify = new J48();
        $data = $classify->getJ48ToJson($output);

        echo json_encode($data);
        //echo $data;
        // $simpleKMeans = new SimpleKMeans();
        // $data = $simpleKMeans->getSimpleKMeansToJson($output);
        // echo $data;
        // return view('company.test')
        //     ->with('user', Auth::user())
        //     ->with('output', $output);
    }

    public function testRegression()
    {
        $pathWekaLib = config('app.weka_lib');
        $pathWekaInput = config('app.weka_input');

        //'-classifications "weka.classifiers.evaluation.output.prediction.CSV "'
        $cmd = "java -cp " . $pathWekaLib . " weka.classifiers.functions.SimpleLinearRegression -v -t " . $pathWekaInput . "cpu.arff";
        //$cmd = "java -cp " . $pathWekaLib . " weka.classifiers.functions.LinearRegression" . ' -classifications "weka.classifiers.evaluation.output.prediction.CSV"' . " -t " . $pathWekaInput . "cpu.arff";

        exec($cmd, $output);
        $simpleLinearRegression = new SimpleLinearRegression();
        $data = $simpleLinearRegression->getToJson($output);
        dd($data);
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

    // public function AnalysisPrepareData()
    // {
    //     return view('company.AnalysisPrepareData')->with('user', Auth::user());
    // }

    // public function DataAnalysis()
    // {
    //     return view('company.DataAnalysis')->with('user', Auth::user());
    // }

    // public function DataAnalysisOutput()
    // {
    //     return view('company.DataAnalysisOutput')->with('user', Auth::user());
    // }
}
