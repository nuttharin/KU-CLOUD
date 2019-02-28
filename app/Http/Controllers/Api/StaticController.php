<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_STATIC\StaticRepository;
use Auth;
use Illuminate\Http\Request;

class StaticController extends Controller
{

    public function __construct(StaticRepository $static)
    {

        // if (!Gate::allows('isCompanyAdmin')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->static = $static;

        // $this->log_viewer = new LogViewer();

        // $this->auth = Auth::user();
        // $company_id = $this->auth->user_company()->first()->company_id;
        // $this->log_viewer->setFolder('COMPANY_' . $company_id);

    }

    public function addStatic(Request $request)
    {
        $message = $this->static->createStatic($request->get('name'));

        return response()->json(["message", $message['message']], $message['status']);
    }

    public function updateStatic(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $this->static->updateStatic($request->get('static_id'), $request->get('name'), $companyID);
    }

    public function updateStaticDashboard(Request $request)
    {
        $data = TB_STATIC::where('static_id', $request->get('static_id'))
            ->update(['dashboard' => $request->get('dashboard')]);
    }

    public function deleteStatic(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;

        $this->static->deleteStatic($request->get('static_id'), $companyID);
    }

    public function getStaticDashboard(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;
        return $this->static->getStaticByCompanyId($companyID);
        // return response()->json(compact('data'), 200);
    }

    public function getStaticDashboardById(Request $request, $static_id)
    {

        $companyID = Auth::user()->user_company()->first()->company_id;
        $data = $this->static->getStaticDashboardById($static_id, $companyID);
        return response()->json(compact('data'), 200);
    }

    public function getDatasourceStatic(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;
        $data = $this->static->getDatasoureByStaticId($request->get('static_id'), $companyID);
        return response()->json(compact('data'), 200);
    }

    public function addDatasourceStatic(Request $request)
    {
        $data = [
            'static_id' => $request->get('static_id'),
            'name' => $request->get('name'),
            'webservice_id' => $request->get('webservice_id'),
            'timeInterval' => $request->get('timeInterval'),
        ];
        $this->static->createDatasource($data);
    }

    public function deleteDatasourceByStatic(Request $request)
    {
        $static_id = $request->get('static_id');
        $id = $request->get('id');
        $this->static->deleteDatasourceByStatic($static_id, $id);
    }
}
