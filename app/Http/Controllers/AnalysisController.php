<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function AnalysisPrepareData(Request $request)
    {
        return view('Analysis.AnalysisPrepareData');
    }

    public function DataAnalysis(Request $request)
    {
        return view('Analysis.DataAnalysis');
    }

    public function DataAnalysisOutput(Request $request)
    {
        return view('Analysis.DataAnalysisOutput');
    }
}
