<?php

namespace App\Repositories\TB_DATA_ANALYSIS;

use App\TB_DATA_ANALYSIS;
use App\Weka\ConvertJsonToArff;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class EloquentDataAnalysis implements DataAnalysisRepository
{

    private $cmd;

    private $pathWekaLib;

    private $pathWekaInput;

    public function __construct()
    {
        $this->cmd = 'java "-Dfile.encoding=utf-8" -cp ';
        $this->param = "";
        $this->pathWekaLib = config('app.weka_lib');
        $this->pathWekaInput = config('app.weka_input');
    }

    public function getAll()
    {
        $data = TB_DATA_ANALYSIS::all();
        return $data;
    }

    public function getByCompany()
    {
        $data = TB_DATA_ANALYSIS::where([
            ['TB_USER_COMPANY.company_id', '=', Auth::user()->user_company()->first()->company_id],
        ])
            ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DATA_ANALYSIS.user_id')
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
            ->get(['TB_DATA_ANALYSIS.data_id', 'TB_DATA_ANALYSIS.name', 'TB_DATA_ANALYSIS.path_file', 'TB_DATA_ANALYSIS.path_file_csv', 'TB_DATA_ANALYSIS.is_success',
                'TB_USERS.user_id', 'TB_USERS.fname', 'TB_USERS.lname',
            ]);
        return $data;
    }

    public function getById($data_id)
    {
        $data = TB_DATA_ANALYSIS::where([
            ['data_id', '=', $data_id],
            ['user_id', '=', Auth::user()->user_id],
        ])->first();
        $this->cmd = 'java "-Dfile.encoding=utf-8" -cp ' . "$this->pathWekaLib weka.core.converters.JSONSaver -i $this->pathWekaInput" . $data->path_file . ".arff";
        exec($this->cmd, $json);
        $json = implode("", $json);
        $data['data'] = json_decode($json, true);
        return $data;
    }

    public function getFileToJsonById($data_id)
    {
        $data = TB_DATA_ANALYSIS::where([
            ['data_id', '=', $data_id],
            ['user_id', '=', Auth::user()->user_id],
        ])->first();
        $this->cmd = 'java "-Dfile.encoding=utf-8" -cp ' . "$this->pathWekaLib weka.core.converters.JSONSaver -i $this->pathWekaInput" . $data->path_file;
        exec($this->cmd, $json);
        $json = implode("", $json);
        $data['data'] = json_decode($json, true);
        return response()->json(compact('data'), 200);
    }

    public function getFileToCSVById($data_id)
    {

    }

    public function create(array $attr)
    {
        DB::beginTransaction();
        try {
            $data = TB_DATA_ANALYSIS::create([
                'user_id' => Auth::user()->user_id,
                'name' => $attr['name'],
            ]);
            $convert = new ConvertJsonToArff();
            $convert->convertToAttr($attr['pathArray'], $attr['name'], $attr['service_id'], $attr['type'], $attr['tableDW_name'], $data->data_id, $attr['period'], $attr['token']);
            //dispatch(new PrepareDataAnalysis($data->data_id, $attr['pathArray'], $attr['name']));
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function delete($data_id, $user_id)
    {
        DB::beginTransaction();
        try {
            $data = TB_DATA_ANALYSIS::where([
                ['data_id', '=', $data_id],
                ['user_id', '=', $user_id],
            ])->first();
            if (!empty($data)) {
                Storage::delete('/weka/input/' . $data->path_file);
                Storage::delete('/weka/input/' . $data->path_file_csv);
                TB_DATA_ANALYSIS::where([
                    ['data_id', '=', $data_id],
                    ['user_id', '=', $user_id],
                ])->delete();
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

}
