<?php

namespace App\Http\Controllers;

use Auth;

class LogViewerController extends Controller
{
    public function Index()
    {
        if (Auth::user()->type_user === "COMPANY") {
            return view('LogViewer.Index_Company')->with('user', Auth::user());
        } else {
            return view('LogViewer.Index_Admin')->with('user', Auth::user());
        }
    }
}
