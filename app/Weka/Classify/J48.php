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

    // public function getJ48ToJson($output)
    // {
    //     $str = "";
    //     $data = [
    //         'outputText' => $output,
    //     ];
    //     $fileTree = str_random(10) . ".dot";
    //     $this->cmd .= " -g > $this->pathWekaInput" . $fileTree;
    //     exec($this->cmd);
    //     $importFile = trim(File::get(storage_path('app/weka/input/') . $fileTree));
    //     $data['tree'] = $importFile;
    //     Storage::delete('/weka/input/' . $fileTree);
    //     return $data;
    // }

    public function getJ48ToJson($output)
    {
        $data = [
            'name' => 'Classify : J48 Tree',
            'outputText' => $output,
        ];
        $fileTree = str_random(10) . ".dot";
        $this->cmd .= " -g > $this->pathWekaInput" . $fileTree;
        exec($this->cmd);
        $importFile = trim(File::get(storage_path('app/weka/input/') . $fileTree));
        $data['tree'] = $importFile;
        Storage::delete('/weka/input/' . $fileTree);
        // $data['Detailed Accuracy By Class']['TP Rate'][0]["value"] = null;
        // $data['Detailed Accuracy By Class']['TP Rate'][0]["type"] = "test";
        // $data['Detailed Accuracy By Class']['TP Rate'][1]["value"] = "test";
        // $data['Detailed Accuracy By Class']['TP Rate'][1]["type"] = "test";
        // $data['Detailed Accuracy By Class']['TP Rate'][0]["value"] = "Test";
        //return $data;
        return self::convertToJson($output,$data, " ", 0);
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
                return self::convertToJson($output, $data, $status, $index + 2);
            }
            else{
                return self::convertToJson($output, $data, "tree", $index + 1);
            }
        } else if ($status == "stratified") {
            $split = preg_split('/\s+/', $str);
            
            $keyString = "";
            $arrayValue = array();

            for($i = 0; $i < sizeOf($split); $i++)
            {
                if(is_numeric($split[$i]))
                {
                    array_push($arrayValue, $split[$i]);
                }
                else if($split[$i] == "%")
                {
                    array_push($arrayValue, $split[$i]);
                }
                else
                {
                    $keyString .= $split[$i]." ";
                }
            }

            $_key = str_replace(' ', '_', trim($keyString));
            $_key = strtolower($_key);
            $sizeArray = sizeOf($arrayValue);

            for($i = 0; $i < sizeOf($arrayValue); $i++)
            {
                if(($i == 0 && $sizeArray == 1) || ($i == 0 && $sizeArray == 2) || ($i == 1 && $sizeArray == 3))
                {
                    $data['stratified_cross_validation'][$_key]['value'] = $arrayValue[$i];
                }
                else if(($i == 1 && $sizeArray == 2) || ($i == 2 && $sizeArray == 3))
                {
                    $data['stratified_cross_validation'][$_key]['type'] = $arrayValue[$i];
                }
                else if($i == 0 && $sizeArray == 3)
                {
                    $data['stratified_cross_validation'][$_key]['instances'] = $arrayValue[$i];
                }
            }

            $status = self::getStatus($output, $index + 1);

            if ($status == "detailed") {
                return self::convertToJson($output, $data, $status, $index + 2);
            }
            else{
                return self::convertToJson($output, $data, "stratified", $index + 1);
            }
        } else if ($status == "detailed")
        {
            $arrayKey = array();
            $keyIndex = 0;

            for($count = 0; $count < 5; $count++)
            {
                $str = trim($output[$index]);
                $split = preg_split('/\s{2}/', $str);
                $keyIndex = 0;
                //print_r($split);

                for($i = 0; $i < sizeOf($split); $i++)
                {
                    if($split[$i] == null)
                    {
                        continue;
                    }

                    if($count == 1)
                    {
                        $_key = str_replace(' ', '_', trim($split[$i]));
                        $_key = strtolower($_key);

                        array_push($arrayKey, $_key);

                        for($j = 0; $j < 3; $j++)
                        {
                            $data['detailed_accuracy_by_class'][$_key][$j]["value"] = null;
                            $data['detailed_accuracy_by_class'][$_key][$j]["type"] = null;
                        }
                    }
                    else if($count == 2 ||$count == 3)
                    {
                        $rowIndex = $count - 2;

                        if($split[$i] != null)
                        {
                            $data['detailed_accuracy_by_class'][$arrayKey[$keyIndex]][$rowIndex]["value"] = $split[$i];
                            if($count == 2)
                            {
                                $data['detailed_accuracy_by_class'][$arrayKey[$keyIndex]][$rowIndex]["type"] = "yes";
                            }
                            else
                            {
                                $data['detailed_accuracy_by_class'][$arrayKey[$keyIndex]][$rowIndex]["type"] = "no";
                            }

                            $keyIndex = $keyIndex + 1;
                        }
                    }
                    else if($count == 4)
                    {
                        $rowIndex = $count - 2;

                        if(is_numeric($split[$i]))
                        {
                            $data['detailed_accuracy_by_class'][$arrayKey[$keyIndex]][$rowIndex]["value"] = $split[$i];
                            $data['detailed_accuracy_by_class'][$arrayKey[$keyIndex]][$rowIndex]["type"] = "avg";

                            $keyIndex = $keyIndex + 1;
                        }
                    }
                }

                $index = $index + 1;
            }


            $status = self::getStatus($output, $index + 2);

            if ($status == "confusion") {
                return self::convertToJson($output, $data, $status, $index + 3);
            }
            else{
                return self::convertToJson($output, $data, "detailed", $index + 1);
            }
        }   
        else if ($status == "confusion")
        {
            $key = trim($str);

            if($key != null)
            {
                $data['confusion_matrix'][] = $key;
            }

            return self::convertToJson($output, $data, $status, $index + 1);
        }
        else {
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
            $str .= $array[$i]."\r\n";
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
    
    public function getArrayStratified($array, $indexCount)
    {

    }
}
