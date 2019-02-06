<?php

namespace App\Weka\Clusterers;

use App\TB_DATA_ANALYSIS;

class SimpleKMeans
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
        $this->cmd .= "$this->pathWekaLib weka.clusterers.SimpleKMeans $this->param -t $this->pathWekaInput" . $file;
        exec($this->cmd, $output);
        return self::getSimpleKMeansToJson($output);
    }

    public function getParam($param)
    {
        if (!is_null($param['number_of_clusters'])) {
            $this->param .= '-N ' . $param['number_of_clusters'] . ' ';
        }
        if (!is_null($param['method'])) {
            $this->param .= '-init ' . $param['method'] . ' ';
        }
        if (!is_null($param['max_candidates'])) {
            $this->param .= '-max-candidates ' . $param['max_candidates'] . ' ';
        }
        if (!is_null($param['min_density'])) {
            $this->param .= '-min-density ' . $param['min_density'] . ' ';
        }
    }

    public function getTableSimpleKMeans($output, $start)
    {
        $table = [];
        for ($i = $start; $i < sizeof($output); $i++) {
            $value = trim($output[$i]);
            preg_match_all("/[a-zA-Z0-9.%]+/", $value, $array_value);
            if ($start - $i === -3) {
                continue;
            }

            if (!sizeOf($array_value[0])) {
                break;
            }

            $table[] = $array_value[0];

        }
        return $table;
    }

    public function getSimpleKMeansToJson($output)
    {
        $str = "";
        $data = [
            'name' => 'kMeans',
            'number_of_iterations' => [
                'text' => 'Number of iterations',
                'value' => 0,
            ],
            'initial_starting_points_random' => [
                'text' => 'Initial starting points (random)',
                'value' => 0,
            ],
            'outputText' => $output,
        ];
        $cluster_count = 0;
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
                $_key = strtolower($_key);
                if ($key == "Cluster " . $cluster_count) {
                    $cluster_count++;
                    $data['clusters'][$_key][] = explode(",", $value);
                } else if ($key !== "Final cluster centroids") {
                    $data[$_key]['text'] = $key;
                    $data[$_key]['value'] = $value;
                } else {
                    $data[$_key]['text'] = $key;
                    $finalCluster = self::getTableSimpleKMeans($output, $i + 1);
                    $data[$_key]['value'] = $finalCluster;
                }
            } else {
                $_key = str_replace(' ', '_', $key);
                $_key = str_replace('(', '', $_key);
                $_key = str_replace(')', '', $_key);
                $_key = str_replace('=', '', $_key);
                $_key = strtolower($_key);
                $_key = strtolower($_key);
                if ($key === "Clustered Instances") {
                    $data[$_key]['header'] = "Clustering stats for training data";
                    $data[$_key]['text'] = $key;
                    $data[$_key]['value'] = self::getTableSimpleKMeans($output, $i + 1);
                }
            }
        }

        return $data;
    }
}
