<?php

namespace App\Weka\Classify;

use App\TB_DATA_ANALYSIS;

class SimpleLinearRegression
{
    private $cmd;

    private $param;

    private $pathWekaLib;

    private $pathWekaInput;

    public function __construct()
    {
        $this->cmd = 'java "-Dfile.encoding=utf-8"  -cp ';
        $this->param = "";
        $this->pathWekaLib = config('app.weka_lib');
        $this->pathWekaInput = config('app.weka_input');
    }

    public function exec($traningFile, $param)
    {
        $file = TB_DATA_ANALYSIS::where('data_id', $traningFile)->first()->path_file;
        self::getParam($param);
        $this->cmd .= "$this->pathWekaLib weka.classifiers.functions.SimpleLinearRegression  -v $this->param -t $this->pathWekaInput" . $file;
        //dd($this->cmd);
        exec($this->cmd, $output);
        return self::getToJson($output);
    }

    public function getParam($param)
    {
        if (!is_null($param['number_of_folds'])) {
            $this->param .= '-x ' . $param['number_of_folds'] . ' ';
        }
        if (!is_null($param['random_number_seed'])) {
            $this->param .= '-s ' . $param['random_number_seed'] . ' ';
        }

    }

    public function getTableCrossValidation($output, $start)
    {
        $table = [];
        for ($i = $start + 2; $i < sizeof($output); $i++) {
            $value = trim($output[$i]);

            $array_value = preg_split('/\s{2}/', $value);
            $array_value = array_values(array_filter($array_value));

            if (count($array_value) > 1) {
                $text = trim($array_value[0]);
                $text = str_replace('(', '', $text);
                $text = str_replace(')', '', $text);
                $text_value = trim($array_value[1]);
                $text_value = str_replace('%', '', $text_value);
                $text_value = str_replace(' ', '', $text_value);

                $val = [
                    'text' => $text,
                    'val' => (float) $text_value,
                    'unit' => '',
                ];

                if ($text == "Relative absolute error" || $text == "Root relative squared error") {
                    $val['unit'] = "%";
                }

                $table[] = $val;
            }

        }
        return $table;
    }

    public function getToJson($output)
    {
        $data = [
            'outputText' => $output,
            'cross_validation' => [
                'header' => 'Cross-validation',
                'value' => null,
            ],
        ];

        for ($i = 0; $i < sizeof($output); $i++) {
            $str = trim($output[$i]);
            $split = explode(":", $str);
            $key = trim($split[0]);
            if (sizeOf($split) > 1) {
                $value = trim($split[1]);
                $_key = str_replace(' ', '_', $key);
                $_key = str_replace('(', '', $_key);
                $_key = str_replace(')', '', $_key);
                $_key = str_replace('=', '', $_key);
                $_key = str_replace('-', '_', $_key);
                $_key = strtolower($_key);
                $data[$_key] = $value;

            } else {
                $_key = str_replace(' ', '_', $key);
                $_key = str_replace('(', '', $_key);
                $_key = str_replace(')', '', $_key);
                $_key = str_replace('=', '', $_key);
                $_key = strtolower($_key);
                $_key = strtolower($_key);
                if ($i == 3) {
                    $data['linear_regression']['header'] = $output[3];
                    $data['linear_regression']['value'] = $output[5];
                } else if ($key == "=== Cross-validation ===") {
                    $data['cross_validation']['value'] = self::getTableCrossValidation($output, $i);
                }
            }
        }
        return $data;
    }

}
