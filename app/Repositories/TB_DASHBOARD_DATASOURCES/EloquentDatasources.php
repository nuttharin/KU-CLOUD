<?php

namespace App\Repositories\TB_DASHBOARD_DATASOURCES;

use App\TB_DASHBOARD_DATASOURCES;
use App\TB_IOTSERVICE;
use App\TB_WEBSERVICE;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentDatasources implements DatasourcesRepository
{
    public function getDatasources($dashboard_id)
    {
        if (Auth::user()->type_user == 'CUSTOMER') {
            $webservices = TB_WEBSERVICE::where([
                ['user_id', '=', Auth::user()->user_id],
            ])
                ->join("TB_REGISTER_WEBSERVICE", "TB_REGISTER_WEBSERVICE.webservice_id", "=", "TB_WEBSERVICE.webservice_id")
                ->get();

            $iot = $iot = TB_IOTSERVICE::where([
                ['user_id', '=', Auth::user()->user_id],
            ])
                ->join("TB_REGISTER_IOT_SERVICE", "TB_REGISTER_IOT_SERVICE.iotservice_id", "=", "TB_IOTSERVICE.iotservice_id")
                ->get();

            $data = [
                'webservices' => $webservices,
                'iot' => $iot,
            ];
        } else if (Auth::user()->type_user == 'ADMIN') {
            $webservices = TB_WEBSERVICE::where([
                ['status', '=', 'public'],
            ])->get();

            $iot = TB_IOTSERVICE::where([
                ['status', '=', 'public'],
            ])->get();

            $data = [
                'webservices' => $webservices,
                'iot' => $iot,
            ];
        } else if (Auth::user()->type_user == 'COMPANY') {
            $webservices = TB_WEBSERVICE::where([
                ['company_id', '=', Auth::user()->user_company()->first()->company_id],
            ])->get();

            $iot = TB_IOTSERVICE::where([
                ['company_id', '=', Auth::user()->user_company()->first()->company_id],
            ])->get();

            $data = [
                'webservices' => $webservices,
                'iot' => $iot,
            ];
        }
        // $data = TB_DASHBOARDS::where([
        //     ['TB_USER_COMPANY.company_id', Auth::user()->user_company()->first()->company_id],
        //     ['TB_DASHBOARDS.dashboard_id', $dashboard_id],
        // ])
        //     ->join('TB_DASHBOARD_DATASOURCES', 'TB_DASHBOARD_DATASOURCES.dashboard_id', '=', 'TB_DASHBOARDS.dashboard_id')
        //     ->join('TB_WEBSERVICE', 'TB_WEBSERVICE.webservice_id', '=', 'TB_DASHBOARD_DATASOURCES.webservice_id')
        //     ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_DASHBOARDS.user_id')
        //     ->get(['TB_DASHBOARD_DATASOURCES.id', 'TB_DASHBOARD_DATASOURCES.name', 'TB_WEBSERVICE.webservice_id', 'TB_DASHBOARD_DATASOURCES.timeInterval', 'TB_DASHBOARD_DATASOURCES.body', 'TB_DASHBOARD_DATASOURCES.headers', 'TB_WEBSERVICE.URL']);
        return \response()->json(compact('data'), 200);
    }

    public function getDatasourcesCustomer($user_id)
    {
        $company_id = Auth::user()->user_company()->first()->company_id;

        $webservices = TB_WEBSERVICE::where([
            ['user_id', '=', $user_id],
            ['company_id', '=', $company_id],
        ])
            ->join("TB_REGISTER_WEBSERVICE", "TB_REGISTER_WEBSERVICE.webservice_id", "=", "TB_WEBSERVICE.webservice_id")
            ->get();

        $iot = $iot = TB_IOTSERVICE::where([
            ['user_id', '=', $user_id],
            ['company_id', '=', $company_id],
        ])
            ->join("TB_REGISTER_IOT_SERVICE", "TB_REGISTER_IOT_SERVICE.iotservice_id", "=", "TB_IOTSERVICE.iotservice_id")
            ->get();

        $data = [
            'webservices' => $webservices,
            'iot' => $iot,
        ];
        return $data;
    }

    public function getDatasourcesPublic()
    {
        $webservices = TB_WEBSERVICE::where([
            ['status', '=', 'public'],
        ])->get();

        $iot = TB_IOTSERVICE::where([
            ['status', '=', 'public'],
        ])->get();

        $data = [
            'webservices' => $webservices,
            'iot' => $iot,
        ];

        return $data;
    }

    public function createDatasource(array $attr)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < sizeof($attr['webservice_id']); $i++) {
                $webservice = TB_WEBSERVICE::where('webservice_id', $attr['webservice_id'][$i])->first();
                $data = [
                    'dashboard_id' => $attr['dashboard_id'],
                    'name' => $webservice->service_name . "#" . $attr['dashboard_id'],
                    'webservice_id' => $attr['webservice_id'][$i],
                    'timeInterval' => $attr['timeInterval'],
                ];
                TB_DASHBOARD_DATASOURCES::create($data);
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function updateDatasource(array $attr)
    {

    }

    public function deleteDatasource($dashboard_id, $id)
    {
        DB::beginTransaction();
        try {
            $data = TB_DASHBOARD_DATASOURCES::where([
                ['dashboard_id', $dashboard_id],
                ['id', $id],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
