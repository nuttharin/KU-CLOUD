<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function AnalysisPrepareData()
    {
        return view('Analysis.AnalysisPrepareData')->with('user', Auth::user());
    }

    public function DataAnalysis()
    {
        return view('Analysis.DataAnalysis')->with('user', Auth::user());
    }

    public function DataAnalysisOutput()
    {
        return view('Analysis.DataAnalysisOutput')->with('user', Auth::user());
    }
}
