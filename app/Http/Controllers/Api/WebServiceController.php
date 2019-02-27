<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebServiceController extends Controller
{
    public function addRegisWebService(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = $request->get('ServiceName') . "." . $companyID;

        $webService = TB_WEBSERVICE::create([
            'company_id' => $companyID,
            'service_name' => $request->get('ServiceName'),
            'service_name_DW' => $nameDW,
            'alias' => $request->get('alias'),
            'URL' => $request->get('strUrl'),
            'description' => $request->get('description'),
            'header_row' => $request->get('header'),
            'value_array' => $request->get('strArr'),
            'value_cal' => $request->get('valueCal'),
            'value_groupby' => $request->get('valueGroup'),
            'status' => $request->get('status'),
            'update_time' => $request->get('time'),
        ]);
        Log::info('Create Web Service - [] SUCCESS');
        return response()->json(compact('webService'), 200);
    }
}
