<?php

namespace App\Weka\Classify;

use App\TB_DATA_ANALYSIS;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class J48
{
    private $cmd;

    private $param;

    private $pathWekaLib;

    private $pathWekaInput;

    public function __construct()
    {
        $this->cmd = "java -cp ";
        $this->param = "";
        $this->pathWekaLib = config('app.weka_lib');
        $this->pathWekaInput = config('app.weka_input');
    }

    public function exec($traningFile, $param)
    {
        $file = TB_DATA_ANALYSIS::where('data_id', $traningFile)->first()->path_file;
        self::getParam($param);
        $this->cmd .= "$this->pathWekaLib weka.classifiers.trees.J48 $this->param -t $this->pathWekaInput" . $file;
        exec($this->cmd, $output);
        return self::getJ48ToJson($output);
    }

    public function getParam($param)
    {
        if (!is_null($param['confidence_threshold'])) {
            $this->param .= '-C ' . $param['confidence_threshold'] . ' ';
        }
        if (!is_null($param['minimum_number_of_instances'])) {
            $this->param .= '-M ' . $param['minimum_number_of_instances'] . ' ';
        }
        // if (!is_null($param['number_of_folds'])) {
        //     $this->param .= '-N ' . $param['number_of_folds'] . ' ';
        // }
    }

    public function getJ48ToJson($output)
    {
        $str = "";
        $data = [
            'outputText' => $output,
        ];
        $fileTree = str_random(10) . ".dot";
        $this->cmd .= " -g > $this->pathWekaInput" . $fileTree;
        exec($this->cmd);
        $importFile = trim(File::get(storage_path('app/weka/input/') . $fileTree));
        $data['tree'] = $importFile;
        Storage::delete('/weka/input/' . $fileTree);
        return $data;
    }
}
