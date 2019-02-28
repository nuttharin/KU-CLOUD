<?php

namespace App\Repositories\TB_DASHBOARD_DATASOURCES;

use App\TB_DASHBOARDS;
use App\TB_DASHBOARD_DATASOURCES;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentDatasources implements DatasourcesRepository
{
    public function getDatasources($dashboard_id)
    {
        $data = TB_DASHBOARDS::where([
            ['TB_USER_COMPANY.company_id', Auth::user()->user_company()->first()->company_id],
            ['TB_DASHBOARDS.dashboard_id', $dashboard_id],
        ])
            ->join('TB_DASHBOARD_DATASOURCES', 'TB_DASHBOARD_DATASOURCES.dashboard_id', '=', 'TB_DASHBOARDS.dashboard_id')
            ->join('TB_WEBSERVICE', 'TB_WEBSERVICE.webservice_id', '=', 'TB_DASHBOARD_DATASOURCES.webservice_id')
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_DASHBOARDS.user_id')
            ->get(['TB_DASHBOARD_DATASOURCES.id', 'TB_DASHBOARD_DATASOURCES.name', 'TB_WEBSERVICE.webservice_id', 'TB_DASHBOARD_DATASOURCES.timeInterval', 'TB_DASHBOARD_DATASOURCES.body', 'TB_DASHBOARD_DATASOURCES.headers', 'TB_WEBSERVICE.URL']);
        return \response()->json(compact('data'), 200);
    }

    public function createDatasource(array $attr)
    {
        DB::beginTransaction();
        try {
            TB_DASHBOARD_DATASOURCES::create($attr);
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
