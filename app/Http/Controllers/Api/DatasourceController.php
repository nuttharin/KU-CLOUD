<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_DASHBOARD_DATASOURCES\DatasourcesRepository;
use Illuminate\Http\Request;

class DatasourceController extends Controller
{

    private $datasources;

    public function __construct(DatasourcesRepository $datasources)
    {
        $this->datasources = $datasources;
    }

    public function getDatasources(Request $request)
    {
        return $this->datasources->getDatasources($request->get('dashboard_id'));
    }

    public function createDatasource(Request $request)
    {

        $attr = [
            'dashboard_id' => $request->get('dashboard_id'),
            'name' => 'api',
            'webservice_id' => $request->get('webservice_id'),
            'timeInterval' => $request->get('timeInterval'),
        ];
        $this->datasources->createDatasource($attr);
    }

    public function updateDatasource(Request $request)
    {

    }

    public function deleteDatasource(Request $request)
    {
        $this->datasources->deleteDatasource($request->get('dashboard_id'), $request->get('id'));
    }
}
