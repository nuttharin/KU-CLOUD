<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_DATA_ANALYSIS\DataAnalysisRepository;
use App\Weka\Associations\Association;
use App\Weka\Classify\J48;
use App\Weka\Classify\SimpleLinearRegression;
use App\Weka\Clusterers\SimpleKMeans;
use App\Weka\UploadFileExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{

    private $dataAnalysis;

    private $cluster;

    private $simpleLinearRegression;

    public function __construct(DataAnalysisRepository $dataAnalysis)
    {
        // if (!Gate::allows('isCompanyAdmin')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        // $this->log_viewer = new LogViewer();

        // $this->auth = Auth::user();
        // $company_id = $this->auth->user_company()->first()->company_id;
        // $this->log_viewer->setFolder('COMPANY_' . $company_id);

        $this->dataAnalysis = $dataAnalysis;
        $this->cluster = new SimpleKMeans();
        $this->associations = new Association();
        $this->j48 = new J48();
        $this->simpleLinearRegression = new SimpleLinearRegression();

    }

    public function createDataAnalysis(Request $request)
    {
        $data = [
            'name' => $request->get('name'),
            'pathArray' => $request->get('pathArray'),
        ];
        $this->dataAnalysis->create($data);
    }

    public function deleteDataAnalysis(Request $request)
    {
        $data = [
            'data_id' => $request->get('data_id'),
            'user_id' => Auth::user()->user_id,
        ];
        $this->dataAnalysis->delete($data['data_id'], $data['user_id']);
    }

    public function uploadFile(Request $request)
    {
        $upload = new UploadFileExcel();
        $upload->uploadFile($request);
    }

    public function getAllDataAnalysis()
    {
        $data = $this->dataAnalysis->getByCompany();
        return response()->json(compact('data'), 200);
    }

    public function getByIdDataAnalysis($data_id,$type = 'json')
    {
        if ($type == "json") {
            return $this->dataAnalysis->getFileToJsonById($data_id);
        } else if ($type == "csv") {

        }
    }

    public function getFileToJsonById($data_id, $type)
    {
       
    }

    public function analysisProcess(Request $request)
    {
        $param = $request->get('param');
        $traningFile = $request->get('traningFile');
        if ($request->get('type') === 'cluster') {
            $data = $this->cluster->exec($traningFile, $param);
        } else if ($request->get('type') === 'associate') {
            $data = $this->associations->exec($traningFile, $param);
        } else if ($request->get('type') === 'J48') {
            $data = $this->j48->exec($traningFile, $param);
        } else if ($request->get('type') === 'regression') {
            $data = $this->simpleLinearRegression->exec($traningFile, $param);
        }
        return response()->json(compact('data'), 200);
    }
}
