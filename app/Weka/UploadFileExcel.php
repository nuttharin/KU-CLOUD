<?php

namespace App\Weka;

use App\TB_DATA_ANALYSIS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadFileExcel
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

    public function uploadFile(Request $request)
    {
        $file = $request->file('file_upload');
        $filename = time() . $file->getClientOriginalName();
        $filenameWeka = \str_replace('.csv', '', $filename);
        $file->storeAs("weka/input", $filename);
        $this->cmd .= "$this->pathWekaLib weka.core.converters.CSVLoader $this->pathWekaInput" . "$filename > " . "$this->pathWekaInput" . "$filenameWeka.arff";
        exec($this->cmd, $output);
        Storage::delete('/weka/input/' . $filename);
        TB_DATA_ANALYSIS::create([
            'user_id' => Auth::user()->user_id,
            'name' => $filenameWeka,
            'path_file' => $filenameWeka . '.arff',
            'is_success' => true,
        ]);
    }
}
