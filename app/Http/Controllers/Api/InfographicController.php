<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
use App\TB_INFOGRAPHIC;
use App\TB_USERS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class InfographicController extends Controller
{

    private $info, $user, $webservice, $auth;

    public function __construct(InfographicRepository $info, UsersRepository $user, WebServiceRepository $webservice)
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
        $this->user = $user;
        $this->webservice = $webservice;

        $this->auth = Auth::user();
    }

    public function getAllInfograpic(Request $request)
    {
        $user_id = $this->auth->user_id;
        $type_user = $this->auth->type_user;

        if($type_user == "COMPANY")
        {
            $company_id = $this->auth->user_company()->first()->company_id;
            $data = $this->info->getInfographicByCompanyId($user_id, $company_id);
        }
        else
        {
            $data = $this->info->getInfographicByUserID($user_id);
        }

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(['data' => $data, 'type_user' => $type_user], 200);
    }

    public function getInfograpicData(Request $request)
    {
        $data = $this->info->getInfographicByInfoID($request->get('info_id'));

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function getCustomerByCompany(Request $request)
    {
        $data = $this->user->getCustomerListByCompany();

        return $data;
    }

    public function createInfograpic(Request $request)
    {
        $userObject = $this->user->getUserById($this->auth->user_id);

        if($request->get('user_id') != null)
        {
            $addinfo = TB_INFOGRAPHIC::create([
                'user_id' => $request->get('user_id'),
                'name' => $request->get('name'),
                'created_by' => $userObject->fname.' '.$userObject->lname,
                'updated_by' => $userObject->fname.' '.$userObject->lname,
            ]);
        }
        else
        {
            $addinfo = TB_INFOGRAPHIC::create([
                'user_id' => $this->auth->user_id,
                'name' => $request->get('name'),
                'created_by' => $userObject->fname.' '.$userObject->lname,
                'updated_by' => $userObject->fname.' '.$userObject->lname,
            ]);
        }

        return response()->json(["status_code", "201"], 201);
    }

    public function updateInfograpic(Request $request)
    {
        $userObject = $this->user->getUserById($this->auth->user_id);

        $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
            ->update([
                'name' => $request->get('name'),
                'updated_by' => $userObject->fname.' '.$userObject->lname,
            ]);

        return response()->json(["status_code", "201"], 201);
    }

    public function updateInfograpicData(Request $request)
    {
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
        $data = $this->info->getInfoDatasourceByInfoID($request->get('info_id'));

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function getServiceByTypeUser(Request $request)
    {
        if($request->get('type_user') == "COMPANY")
        {
            return $this->webservice->getServiceByCompany();
        }
        else if($request->get('type_user') == "CUSTOMER")
        {
            return $this->webservice->getServiceByCustomer();
        }
        else
        {
            return $this->webservice->getServiceByCompany();
        }

    }

    public function getApiDaily(Request $request)
    {
        $data = [];

        $data["daily"][0] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 10,
            "Stations-Observe-StationPressure-Value-\$max" => 1008.1,
            "Stations-Observe-Temperature-Value-\$min" => 32.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796821.4,
            "Stations-Observe-Temperature-Value-\$avg" => 32.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1008.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 0.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 0.0,
            "day" => "12-06-2017"];

        $data["daily"][1] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 15,
            "Stations-Observe-StationPressure-Value-\$max" => 2008.1,
            "Stations-Observe-Temperature-Value-\$min" => 42.3,
            "Stations-Observe-StationPressure-Value-\$min" => 2008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 510016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12795555.4,
            "Stations-Observe-Temperature-Value-\$avg" => 42.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1060.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 5.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 5.0,
            "day" => "13-06-2017"];

        $data["daily"][2] = [             
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 19,
            "Stations-Observe-StationPressure-Value-\$max" => 1055.1,
            "Stations-Observe-Temperature-Value-\$min" => 55.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1055.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410055.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796855.4,
            "Stations-Observe-Temperature-Value-\$avg" => 55.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1055.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 10.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 10.0,
            "day" => "14-06-2017"];

        return response()->json(compact('data'), 200);
    }

    public function getApiMonthly(Request $request)
    {
        $data = [];

        $data["monthly"][0] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 20,
            "Stations-Observe-StationPressure-Value-\$max" => 1008.1,
            "Stations-Observe-Temperature-Value-\$min" => 21.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796821.4,
            "Stations-Observe-Temperature-Value-\$avg" => 23.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1008.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 0.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 0.0,
            "day" => "06-2017"];

        $data["monthly"][1] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 25,
            "Stations-Observe-StationPressure-Value-\$max" => 2008.1,
            "Stations-Observe-Temperature-Value-\$min" => 52.3,
            "Stations-Observe-StationPressure-Value-\$min" => 2008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 510016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12795555.4,
            "Stations-Observe-Temperature-Value-\$avg" => 52.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1060.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 5.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 5.0,
            "day" => "07-2017"];

        $data["monthly"][2] = [             
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 29,
            "Stations-Observe-StationPressure-Value-\$max" => 1055.1,
            "Stations-Observe-Temperature-Value-\$min" => 65.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1055.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410055.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796855.4,
            "Stations-Observe-Temperature-Value-\$avg" => 65.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1055.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 10.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 10.0,
            "day" => "08-2017"];

        return response()->json(compact('data'), 200);
    }

    public function getApiYearly(Request $request)
    {
        $data = [];

        $data["yearly"][0] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 30,
            "Stations-Observe-StationPressure-Value-\$max" => 1008.1,
            "Stations-Observe-Temperature-Value-\$min" => 21.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796821.4,
            "Stations-Observe-Temperature-Value-\$avg" => 23.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1008.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 0.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 0.0,
            "day" => "06-2017"];

        $data["yearly"][1] = [
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 35,
            "Stations-Observe-StationPressure-Value-\$max" => 2008.1,
            "Stations-Observe-Temperature-Value-\$min" => 52.3,
            "Stations-Observe-StationPressure-Value-\$min" => 2008.1,
            "Stations-Observe-Temperature-Value-\$sum" => 510016.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12795555.4,
            "Stations-Observe-Temperature-Value-\$avg" => 52.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1060.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 5.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 5.0,
            "day" => "07-2017"];

        $data["yearly"][2] = [             
            "_id" => "PATTANI AIRPORT",
            "Stations-Observe-Temperature-Value-\$max" => 39,
            "Stations-Observe-StationPressure-Value-\$max" => 1055.1,
            "Stations-Observe-Temperature-Value-\$min" => 65.3,
            "Stations-Observe-StationPressure-Value-\$min" => 1055.1,
            "Stations-Observe-Temperature-Value-\$sum" => 410055.2,
            "Stations-Observe-StationPressure-Value-\$sum" => 12796855.4,
            "Stations-Observe-Temperature-Value-\$avg" => 65.3,
            "Stations-Observe-StationPressure-Value-\$avg" => 1055.1,
            "Stations-Observe-Temperature-Value-\$stdDevSamp" => 10.0,
            "Stations-Observe-StationPressure-Value-\$stdDevSamp" => 10.0,
            "day" => "08-2017"];

        return response()->json(compact('data'), 200);
    }
}
