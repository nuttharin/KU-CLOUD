<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LogViewerController extends Controller
{
    public function Index(Request $request)
    {
        if ($request->session()->get('user')->type_user == 'COMPANY') {
            return view('LogViewer.Index_Company');
        } else {
            return view('LogViewer.Index_Admin');
        }
    }
}
