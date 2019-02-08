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
        $this->cmd .= "$this->pathWekaLib weka.classifiers.trees.J48 -v $this->param -t $this->pathWekaInput" . $file;
        //dd($this->cmd);
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

    public function getClassifyToJson($output)
    {
        $data = [
            'name' => 'Classify : J48 Tree',
            'outputText' => $output,
        ];

        return self::convertToJson($output, $data, " ", 0);
    }

    public function convertToJson($output, $data, $status, $index)
    {
        if ($index >= sizeof($output)) {
            return $data;
        }

        $str = trim($output[$index]);

        if ($status == "tree") {
            $split = explode("=", $str);

            if (sizeOf($split) > 1) {
                $start = $index;
                $end = self::countLengthEqual($index, $output);
                $data['j48_pruned_tree']['tree_value'] = self::arrayLengthJoin($output, $start, $end);
                return self::convertToJson($output, $data, $status, $end + 1);
            }

            $splitSemi = explode(":", $str);

            if (sizeOf($splitSemi) > 1) {

                $key = trim($splitSemi[0]);
                $value = trim($splitSemi[1]);

                $_key = str_replace(' ', '_', $key);
                $_key = strtolower($_key);

                $splitValue = explode(" ", $value);

                if (sizeOf($splitValue) > 1) {
                    $data['j48_pruned_tree'][$_key]['value'] = trim($splitValue[0]);
                    $data['j48_pruned_tree'][$_key]['unit'] = trim($splitValue[1]);
                } else {
                    $data['j48_pruned_tree'][$_key] = trim($splitValue[0]);
                }
            }

            $status = self::getStatus($output, $index + 1);

            if ($status == "stratified") {
                return self::convertToJson($output, $data, $status, $index + 1);
            }

            return self::convertToJson($output, $data, "tree", $index + 1);
        } else if ($status == "stratified") {
            $status = self::getStatus($output, $index + 1);
            return self::convertToJson($output, $data, $status, $index + 1);
        } else {
            $status = self::getStatus($output, $index + 1);
            return self::convertToJson($output, $data, $status, $index + 1);
        }
    }

    public function getStatus($output, $index)
    {
        if ($index >= sizeof($output)) {
            return " ";
        }

        $str = trim($output[$index]);

        if (strpos($str, 'J48 pruned tree') !== false) {
            return "tree";
        } else if (strpos($str, 'Stratified cross-validation') !== false) {
            return "stratified";
        } else if (strpos($str, 'Detailed Accuracy By Class') !== false) {
            return "detailed";
        } else if (strpos($str, 'Confusion Matrix') !== false) {
            return "confusion";
        } else {
            return " ";
        }
    }

    public function arrayLengthJoin($array, $start, $end)
    {
        $str = "";

        for ($i = $start; $i <= $end; $i++) {
            $str .= $array[$i] . "\r\n";
        }

        return $str;
    }

    public function countLengthEqual($index, $output)
    {
        $str = trim($output[$index]);
        if (strpos($str, '=') !== false) {
            return self::countLengthEqual($index + 1, $output);
        } else {
            return $index - 1;
        }
    }
}
