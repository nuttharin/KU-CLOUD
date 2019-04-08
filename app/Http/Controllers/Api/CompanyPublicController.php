<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TB_COMPANY\CompanyRepository;
use File;
use Illuminate\Http\Request;
use Response;

class CompanyPublicController extends Controller
{
    private $companies;

    public function __construct(CompanyRepository $companies)
    {
        $this->log_viewer = new LogViewer();
        $this->log_viewer->setFolder('KU_CLOUD');
        $this->companies = $companies;
    }

    public function getLogoCompany($file_logo)
    {

        $path = storage_path('app/uploadLogoCompany/' . $file_logo);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function getCompanyList(Request $request)
    {
        $data = $this->companies->getCompanyWithAddress($request->get('search'));
        return response()->json(compact('data'), 201);
    }
}
