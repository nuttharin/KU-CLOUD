<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\LogViewer\LogViewer;

use Log;

use DB;
use Gate;
use App\TB_WEBSERVICE;

class AdminController extends Controller
{

    private $log_viewer;

    public function __construct()
    {
        if(!Gate::allows('isAdmin')){
            abort('403',"Sorry, You can do this actions");
        }
        $this->log_viewer = new LogViewer();
        $this->log_viewer->setFolder('KU_CLOUD');
    }

    public function manageAccounts()
    {
        return view('admin.manageAccounts')->with('user', Auth::user());
    }

    public function UsersAdminister()
    {
        return view('admin.UsersAdminister')->with('user', Auth::user());
    }

    public function UsersCompany()
    {
        return view('admin.UsersCompany')->with('user', Auth::user());
    }

    public function UsersCustomer()
    {
        return view('admin.UsersCustomer')->with('user', Auth::user());
    }

    public function Company()
    {
        return view('admin.Company')->with('user', Auth::user());
    }

    public function Infographic()
    {
        return view('admin.Infographic')->with('user', Auth::user());
    }

    public function InfographicCustom($id)
    {
        return view('admin.Infographic_customize')
        ->with('id',$id)
        ->with('user', Auth::user());
    }

    public function staticDatatable()
    {
        return view('admin.staticDataTable')->with('user', Auth::user());
    }

    function static($id) {
        return view('admin.static')
            ->with('id', $id)
            ->with('user', Auth::user());
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
        return view('admin.LogViewer')->with(['data'=>$data])
        ->with('user', Auth::user());
    }

    public function AddService()
    {
        return view('admin.add_webService')->with('user', Auth::user());
    }
    public function EditService($id)
    {
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE TB_WEBSERVICE.webservice_id='$id'");
        return view('admin.edit_webService')->with('webService',$webService)
        ->with('user', Auth::user());
    }


}
