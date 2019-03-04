<?php

namespace App\Weka\Classify;

use App\TB_DATA_ANALYSIS;
use ChrisKonnertz\StringCalc\StringCalc;

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
        $this->value = "";
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

    public function cal($str)
    {
        if (preg_match('/(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/', $str, $matches) !== false) {
            $operator = $matches[2];

            switch ($operator) {
                case '+':
                    $p = $matches[1] + $matches[3];
                    break;
                case '-':
                    $p = $matches[1] - $matches[3];
                    break;
                case '*':
                    $p = $matches[1] * $matches[3];
                    break;
                case '/':
                    $p = $matches[1] / $matches[3];
                    break;
            }

            echo $p;
        }

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
                    $split = preg_split('/\s{1}/', $output[3]);
                    $this->value = $split[sizeof($split) - 1];
                } else if ($key == "=== Cross-validation ===") {
                    $data['cross_validation']['value'] = self::getTableCrossValidation($output, $i);
                }
            }
        }

        //plot กราฟ
        $this->cmd = 'java "-Dfile.encoding=utf-8" -cp ' . "$this->pathWekaLib weka.core.converters.JSONSaver -i $this->pathWekaInput" . "cpu.arff";
        exec($this->cmd, $json);
        $json = implode("", $json);
        $json = json_decode($json, true);

        $index = 0;

        for ($i = 0; $i < sizeof($json['header']['attributes']); $i++) {
            if ($json['header']['attributes'][$i]['name'] === $this->value) {
                $index = $i;
                break;
            }
        }

        $max = 0;
        $min = 0;

        for ($i = 0; $i < sizeof($json['data']); $i++) {
            if ($i == 0) {
                $min = (float) $json['data'][$i]['values'][$index];
            }

            if ((float) $json['data'][$i]['values'][$index] >= $max) {
                $max = (float) $json['data'][$i]['values'][$index];
            }

            if ((float) $json['data'][$i]['values'][$index] <= $min) {
                $min = (float) $json['data'][$i]['values'][$index];
            }
        }

        $cal = new StringCalc();

        $input = str_replace($this->value, $max, $data['linear_regression']['value']);
        $val_max = $cal->calculate($input);
        $input = str_replace($this->value, $min, $data['linear_regression']['value']);
        $val_min = $cal->calculate($input);

        $data['plot'] = [
            "max" => [
                "x" => $max,
                "y" => $val_max,
            ],
            "min" => [
                "x" => $min,
                "y" => $val_min,
            ],
        ];

        return $data;
    }

}
