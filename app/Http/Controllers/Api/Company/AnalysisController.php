<?php

namespace App\Http\Controllers\Api\Company;

use App\Weka\Classify\J48;
use App\LogViewer\LogViewer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Weka\Clusterers\SimpleKMeans;
use App\Weka\Associations\Association;
use App\Repositories\TB_DATA_ANALYSIS\DataAnalysisRepository;

class AnalysisController extends Controller
{
    private $dataAnalysis;

    private $cluster;

    public function __construct(DataAnalysisRepository $dataAnalysis)
    {
        if (!Gate::allows('isCompanyAdmin')) {
            abort('403', "Sorry, You can do this actions");
        }

        $this->log_viewer = new LogViewer();

        $this->auth = Auth::user();
        $company_id = $this->auth->user_company()->first()->company_id;
        $this->log_viewer->setFolder('COMPANY_' . $company_id);

        $this->dataAnalysis = $dataAnalysis;
        $this->cluster = new SimpleKMeans();
        $this->associations = new Association();
        $this->j48 = new J48();
  
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

    public function analysisProcess(Request $request)
    {
        $param = $request->get('param');
        $traningFile = $request->get('traningFile');
        if ($request->get('type') === 'cluster') {
            $data = $this->cluster->exec($traningFile, $param);
        } else if ($request->get('type') === 'associate') {
            $data = $this->associations->exec($traningFile, $param);
        }
        else if($request->get('type') === 'J48'){
            $data = $this->j48->exec($traningFile, $param);
        }
        return response()->json(compact('data'), 200);
    }
}
