<?php

namespace App\Weka;

use App\TB_DATA_ANALYSIS;
use Illuminate\Support\Facades\Storage;

class ConvertJsonToArff
{

    private $cmd;

    private $param;

    private $pathWekaLib;

    private $pathWekaInput;

    public function __construct()
    {
        $this->cmd = 'java "-Dfile.encoding=utf-8" -cp ';
        $this->param = "";
        $this->pathWekaLib = config('app.weka_lib');
        $this->pathWekaInput = config('app.weka_input');
    }

    public function ArrayGetPath($data, $path, &$result)
    {

        $found = true;

        $path = explode("/", $path);

        for ($x = 0; ($x < count($path) and $found); $x++) {

            $key = $path[$x];

            if (isset($data[$key])) {
                $data = $data[$key];
            } else { $found = false;}
        }

        $result = $data;

        return $found;
    }

    public function getTypeWeka($data)
    {
        switch (gettype($data)) {
            case 'string':
                return 'string';
            case 'integer':
                return 'numeric';
            case 'double':
                return 'real';
            default:
                return '?';
        }
    }

    public function createAttrWeka($pathArray)
    {

    }

    public function convertToAttr($pathArray = null, $name = 'test', $data_id)
    {
        $path = public_path() . "/js/company/testConvert.json";
        $json = json_decode(file_get_contents($path), true);
        $csv = "";
        for ($i = 0; $i < sizeof($pathArray); $i++) {
            $csv .= str_replace('/', '_', $pathArray[$i]);
            if ($i != sizeof($pathArray) - 1) {
                $csv .= ",";
            }
        }
        $csv .= "\r\n";
        for ($j = 0; $j < sizeof($json); $j++) {
            for ($x = 0; $x < count($pathArray); $x++) {
                self::ArrayGetPath($json[$j], $pathArray[$x], $result);
                $csv .= $result;
                if ($x != count($pathArray) - 1) {
                    $csv .= ",";
                }
            }
            $csv .= "\r\n";
        }
        $nameCsv = time() . $name . ".csv";
        $nameArff = time() . $name . ".arff";
        Storage::put("/weka/input/" . $nameCsv, $csv);
        $this->cmd .= "$this->pathWekaLib weka.core.converters.CSVLoader $this->pathWekaInput" . "$nameCsv > " . "$this->pathWekaInput" . $nameArff;
        exec($this->cmd, $output);
        Storage::delete('/weka/input/' . $nameCsv);
        TB_DATA_ANALYSIS::where('data_id', $data_id)
            ->update([
                'path_file' => $nameArff,
                'is_success' => true,
            ]);
        return;

        //arff
        // $arffFile = "@relation " . $name . "\r\n";
        // $path = public_path() . "/js/company/testConvert.json";
        // $json = json_decode(file_get_contents($path), true);

        // $attr = "";
        // for ($i = 0; $i < sizeof($pathArray); $i++) {
        //     self::ArrayGetPath($json[0], $pathArray[$i], $result);
        //     $type = self::getTypeWeka($result);
        //     $attr .= "@attribute " . str_replace('/', '_', $pathArray[$i] . ' ' . $type . "\r\n");
        // }

        // $arffFile .= $attr . "\r\n";
        // $arffFile .= "@data\r\n";
        // for ($j = 0; $j < sizeof($json); $j++) {
        //     for ($x = 0; $x < count($pathArray); $x++) {
        //         self::ArrayGetPath($json[$j], $pathArray[$x], $result);

        //         // if (gettype($result) == 'string') {
        //         //     $result = '"' . $result . '"';
        //         // }
        //         $arffFile .= $result;
        //         if ($x != count($pathArray) - 1) {
        //             $arffFile .= ",";
        //         }
        //     }
        //     $arffFile .= "\r\n";
        // }

        // $nameSave = str_random(10) . $name . '.arff';
        // Storage::put("/weka/input/" . $nameSave, $arffFile);
        // TB_DATA_ANALYSIS::where('data_id', $data_id)
        //     ->update([
        //         'path_file' => $nameSave,
        //         'is_success' => true,
        //     ]);
        // return;
    }

}

// $test_path = $pathArray[$x];

// // test path:
// if (self::ArrayGetPath($json[$j], $test_path, $result)) {
//     print "The array path '$test_path' was found, showing content:<br/>\n<pre>";
//     print_r($result . " type : " . gettype($result));
//     print "</pre>";
// } else {print "The array path '$test_path' was not found!<br/>\n";}

// print "<br/>\n";
