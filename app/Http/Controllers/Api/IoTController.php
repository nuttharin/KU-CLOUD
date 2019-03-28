<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;
use App\TB_IOTSERVICE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;

class IoTController extends Controller
{
    public function getKeyiot()
    {
        $key = 'klflvpekvlvep[clep[lc';
        return response()->json(compact('key'), 200);
    }
    public function iotupdatedata(Request $request)
    {
        // $companyID = Auth::user()->user_company()->first()->company_id;
        // $nameDW = "IoT.Input.".$request->get('ServiceName') . "." . $companyID;

        $iotService = TB_IOTSERVICE::where('iotservice_id', $request->get('id_DB'))
        ->update([
            'dataOutput' => $request->get('strJson'),
            'strJson' => $request->get('pinfilds'),
        ]);
        return response()->json(["status", "success"], 200);
    }
    public function deleteIoT(Request $request)
    {
        $iotService = TB_IOTSERVICE::where('iotservice_id', $request->get('id'))
            ->delete();
        return response()->json(["status", "success"], 200);
    }
    public function getAllIotserviceData(Request $request)
    {
      
        $companyID =  Auth::user()->user_company()->first()->company_id;
        $iotService = DB::select("SELECT TB_IOTSERVICE.iotservice_id as id,TB_IOTSERVICE.company_id as idCompany,TB_IOTSERVICE.iot_name as name,TB_IOTSERVICE.iot_name_DW,TB_IOTSERVICE.url,TB_IOTSERVICE.alias,TB_IOTSERVICE.type,TB_IOTSERVICE.description,strJson,TB_IOTSERVICE.value_cal,TB_IOTSERVICE.status,TB_IOTSERVICE.dataOutput,TB_IOTSERVICE.created_at,TB_IOTSERVICE.updated_at
        FROM TB_IOTSERVICE WHERE TB_IOTSERVICE.company_id='$companyID'");

        if (empty($iotService)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('iotService'), 200);
    }
    public function IoTdata(Request $request)
    {
      
        $companyID =  Auth::user()->user_company()->first()->company_id;
        $iotService = DB::select("SELECT TB_IOTSERVICE.iotservice_id as id,TB_IOTSERVICE.company_id as idCompany,TB_IOTSERVICE.iot_name as name,TB_IOTSERVICE.iot_name_DW 
        FROM TB_IOTSERVICE WHERE TB_IOTSERVICE.company_id='$companyID' and TB_IOTSERVICE.type='input'");

        if (empty($iotService)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('iotService'), 200);
    }
    public function addRegisIotService(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;
        $nameDW = "IoT.Input.".$request->get('ServiceName') . "." . $companyID;

        $iotService = TB_IOTSERVICE::create([
            'company_id' => $companyID,
            'iot_name' => $request->get('ServiceName'),
            'iot_name_DW' => $nameDW,
            'url'=>$request->get('urls'),
            'type' => $request->get('type'),
            'alias' => $request->get('alias'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'url_onoff_input' => $request->get('strUrl'),
            'dataformat' => $request->get('datajson'),
            'value_cal' => $request->get('valueCal'),
            'value_gropby' => $request->get('valueGroupby'),
            'updatetime_input' => $request->get('updatetime_input'),
        ]);
        return response()->json(compact('iotService'), 200);
    }
    public function addRegisIotService_url(Request $request)
    {
        
        $iotService = TB_IOTSERVICE::where('iotservice_id', $request->get('idIoT'))
            ->update([
                'url' => $request->get('urls'),
            ]);
        return response()->json(["status", "success"], 200);
    }
    public function addOutputRegisIotService(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;
        $nameDW = "IoT.Output.".$request->get('ServiceName') . "." . $companyID;

        $iotService = TB_IOTSERVICE::create([
            'company_id' => $companyID,
            'iot_name' => $request->get('ServiceName'),
            'iot_name_DW' => $nameDW,
            'type' => $request->get('type'),
            'alias' => $request->get('alias'),
            'description' => $request->get('description'),
            'status' => $request->get('stats'),
            'url' => $request->get('urls'),
            'strJson' => $request->get('showJsonstr'),
            'dataOutput' => $request->get('pinfilds'),
            'value_cal' => $request->get('valueCal'),
        ]);
        return response()->json(compact('iotService'), 200);
    }

    public function getDataOutput(Request $request)
    {
        // $idService =  $request->get('idOutputService');
        // $iotService = DB::select("SELECT * FROM TB_IOTSERVICE WHERE TB_IOTSERVICE.company_id='$idService'");

        // if (empty($iotService)) {
        //     return response()->json(['message' => 'not have data'], 200);
        // }

        // return response()->json(compact('iotService'), 200);
    }
}
