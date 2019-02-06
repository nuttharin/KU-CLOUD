<?php

namespace App\Weka;

use App\TB_DATA_ANALYSIS;
use Illuminate\Support\Facades\Storage;

class ConvertJsonToArff
{

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
        // $pathArray = [
        //     'Stations/Observe/MeanSeaLevelPressure/Value',
        //     'Stations/Observe/RelativeHumidity/Value',
        //     'Stations/Observe/LandVisibility/Value',
        // ];
        $arffFile = "@relation " . $name . "\r\n";
        $path = public_path() . "/js/company/testConvert.json";
        $json = json_decode(file_get_contents($path), true);

        $attr = "";
        for ($i = 0; $i < sizeof($pathArray); $i++) {
            self::ArrayGetPath($json[0], $pathArray[$i], $result);
            $type = self::getTypeWeka($result);
            $attr .= "@attribute " . str_replace('/', '_', $pathArray[$i] . ' ' . $type . "\r\n");
        }

        $arffFile .= $attr . "\r\n";
        $arffFile .= "@data\r\n";
        for ($j = 0; $j < sizeof($json); $j++) {
            for ($x = 0; $x < count($pathArray); $x++) {
                self::ArrayGetPath($json[$j], $pathArray[$x], $result);

                // if (gettype($result) == 'string') {
                //     $result = '"' . $result . '"';
                // }
                $arffFile .= $result;
                if ($x != count($pathArray) - 1) {
                    $arffFile .= ",";
                }
            }
            $arffFile .= "\r\n";
        }
        Storage::put($name . '.arff', $arffFile);
        TB_DATA_ANALYSIS::where('data_id', $data_id)
            ->update([
                'is_success' => true,
            ]);
        return;
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
