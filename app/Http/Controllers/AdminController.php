<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

use App\LogViewer\LogViewer;

use Log;


class AdminController extends Controller
{

    private $log_viewer;

    public function __construct()
    {
        $this->log_viewer = new LogViewer();
        $this->log_viewer->setFolder('KU_CLOUD');
        Log::debug('test');
    }

    public function UsersAdminister()
    {
        return view('admin.UsersAdminister');
    }

    public function UsersCompany()
    {
        return view('admin.UsersCompany');
    }

    public function UsersCustomer()
    {
        return view('admin.UsersCustomer');
    }

    public function Company()
    {
        return view('admin.Company');
    }

    public function Infographic()
    {
        return view('admin.Infographic');
    }

    public function Static()
    {
        return view('admin.Static');
    }
    public function service()
    {
        return view('admin.service')->with('user', Auth::user());
    }
    public function Add_service()
    {
        return view('admin.add_webService')->with('user', Auth::user());
    }

    public  function LogViewer(){
        $folderFiles = $this->log_viewer->getFolderFiles();
        $data = [
            'logs' => $this->log_viewer->all(),
            'folders' => $this->log_viewer->getFolders(),
            'current_folder' => $this->log_viewer->getFolderName(),
            'folder_files' => $folderFiles,
            'files' => $this->log_viewer->getFiles(true),
            'current_file' => $this->log_viewer->getFileName(),
            'standardFormat' => true,
        ];
      

        if (is_array($data['logs'])) {
            $firstLog = reset($data['logs']);
            if (!$firstLog['context'] && !$firstLog['level']) {
                $data['standardFormat'] = false;
            }
        }
        //dd($data);
        return view('admin.LogViewer')->with(['data'=>$data]);
    }

    public function AddService()
    {
        return view('admin.addService');
    }


}
