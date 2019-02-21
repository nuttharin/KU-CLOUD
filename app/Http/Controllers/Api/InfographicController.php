<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;
use App\TB_INFOGRAPHIC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class InfographicController extends Controller
{

    private $info;

    public function __construct(InfographicRepository $info)
    {
        // if (!Gate::allows('isAdmin')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        // $this->users = $users;
        // $this->company = $company;
        // $this->webservices = $webservices;
        // $this->static = $static;

        // $this->log_viewer = new LogViewer();
        // $this->log_viewer->setFolder('KU_CLOUD');

        $this->info = $info;

        $this->auth = Auth::user();
    }

    public function getAllInfograpic(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->info->getInfographicByUserID($payload["sub"]);

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function getInfograpicData(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->info->getInfographicByInfoID($request->get('info_id'));

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function createInfograpic(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();

        $addinfo = TB_INFOGRAPHIC::create([
            'user_id' => $payload["sub"],
            'name' => $request->get('name'),
        ]);

        return response()->json(["status_code", "201"], 201);
    }

    public function updateInfograpic(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();

        $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
            ->update([
                'name' => $request->get('name'),
            ]);

        return response()->json(["status_code", "201"], 201);
    }

    public function updateInfograpicData(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();

        $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
            ->update([
                'info_data' => $request->get('info_data'),
            ]);

        return response()->json(["status_code", "201"], 201);
    }

    public function deleteInfograpic(Request $request)
    {
        $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
            ->delete();
        return response()->json(["status", "success"], 200);
    }

    public function addDatasourceInfo(Request $request)
    {
        $data = [
            'info_id' => $request->get('info_id'),
            'name' => $request->get('name'),
            'webservice_id' => $request->get('webservice_id'),
            'timeInterval' => $request->get('timeInterval'),
        ];
        $this->info->createInfoDatasource($data);
    }

    public function getDatasourceInfo(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->info->getInfoDatasourceByInfoID($request->get('info_id'));

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }
}
