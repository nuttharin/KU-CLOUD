<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\LogViewer\LogViewer;
use App\Repositories\TB_DATA_ANALYSIS\DataAnalysisRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnalysisController extends Controller
{
    private $dataAnalysis;

    public function __construct(DataAnalysisRepository $dataAnalysis)
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('403', "Sorry, You can do this actions");
        }

        $this->dataAnalysis = $dataAnalysis;

        $this->log_viewer = new LogViewer();

        $this->auth = Auth::user();
        $company_id = $this->auth->user_company()->first()->company_id;
        $this->log_viewer->setFolder('COMPANY_' . $company_id);

    }

    public function createDataAnalysis(Request $request)
    {
        $data = [
            'name' => $request->get('name'),
            'pathArray' => $request->get('pathArray'),
        ];
        $this->dataAnalysis->create($data);
    }

    public function getAllDataAnalysis()
    {
        $data = $this->dataAnalysis->getByCompany();
        return response()->json(compact('data'), 200);
    }

    public function getByIdDataAnalysis($data_id)
    {
        $data = $this->dataAnalysis->getById($data_id);
        return response()->json(compact('data'), 200);
    }
}
