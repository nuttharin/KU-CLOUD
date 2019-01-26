<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\LogViewer\LogViewer;
use App\LogViewer\SizeLog;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_STATIC\StaticRepository;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
use App\TB_STATIC;
use App\TB_USERS;
use App\TB_WEBSERVICE;
use Auth;
use DB;
use Gate;
use Illuminate\Http\Request;
use JWTAuth;
use Log;

class CompanyController extends Controller
{
    private $users;
    private $companies;
    private $auth;
    private $webservices;
    private $static;

    public function __construct(UsersRepository $users,
        CompanyRepository $companies,
        WebServiceRepository $webservices,
        StaticRepository $static,
        Request $request) {

        if (!Gate::allows('isCompanyAdmin')) {
            abort('403', "Sorry, You can do this actions");
        }

        $this->users = $users;
        $this->companies = $companies;
        $this->webservices = $webservices;
        $this->static = $static;

        $this->log_viewer = new LogViewer();

        $this->auth = Auth::user();
        $company_id = $this->auth->user_company()->first()->company_id;
        $this->log_viewer->setFolder('COMPANY_' . $company_id);

    }

    public function test()
    {
        $user = $this->auth;
        return response()->json(compact('user'), 201);
    }

    public function getAllUser(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');
        $total_user = $this->users->countUser('COMPANY', $companyID)[0]->count;

        if (empty($search)) {
            $data = $this->users->getByTypeForCompany('COMPANY', $companyID, $start, $length);

            if (!empty($data)) {
                $this->log_viewer->logRequest($request);
                $test = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_user,
                    'recordsFiltered' => $total_user,
                    'data' => $data,
                );

                return response()->json($test, 200);
            }
        } else {
            $data = $this->users->searchByTypeForCompany('COMPANY', $companyID, $start, $length, $search);
            if (!empty($data)) {
                $this->log_viewer->logRequest($request);
                $test = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_user,
                    'recordsFiltered' => count($data),
                    'data' => $data,
                );

                return response()->json($test, 200);
            }
        }
        return response()->json([
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
        ], 200);
    }

    public function addUserCompany(UsersRequest $request)
    {
        $data = [
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => $request->get('password'),
            'type_user' => 'COMPANY',
            'company_id' => $this->auth->user_company()->first()->company_id,
            'sub_type_user' => $request->get('sub_type_user'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
        ];

        $this->users->create($data);

        // $name = $request->get('fname')." ".$request->get('lname');
        // $email = $request->get('email');

        // $verification_code = str_random(30); //Generate verification code

        // DB::table('USER_VERIFICATIONS')->insert(['user_id'=>$user->user_id,'token'=>$verification_code]);
        // $subject = "Please verify your email address.";
        // Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email],
        //     function($mail) use ($email, $name, $subject){
        //         $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD Name Goes Here");
        //         $mail->to($email, $name);
        //         $mail->subject($subject);
        // });

        //$request->bearerToken(),201

        return response()->json(["status_code", "201"], 201);
    }

    public function editUserCompany(Request $request)
    {
        $data = [
            'user_id' => $request->get('user_id'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'phone_user' => $request->get('phone_user'),
            'email_user' => $request->get('email_user'),
        ];
        $this->users->update($data);
    }

    public function deleteEmailUser(Request $request)
    {
        $data = [
            'email_user' => $request->get('email_user'),
        ];
        $this->users->deleteEmailUser($data);
    }

    public function deletePhoneUser(Request $request)
    {
        $data = [
            'phone_user' => $request->get('phone_user'),
        ];
        $this->users->deletePhoneUser($data);
    }

    public function blockUserCompany(Request $request)
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->update(['block' => $request->get('block')]);
        return response()->json(["status", "success"], 200);
    }

    public function getAllCustomer(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');
        $total_user = $this->users->countUser('CUSTOMER', $companyID)[0]->count;

        if (empty($search)) {
            $data = $this->users->getByTypeForCompany('CUSTOMER', $companyID, $start, $length);
            if (!empty($data)) {
                $this->log_viewer->logRequest($request);
                $test = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_user,
                    'recordsFiltered' => $total_user,
                    'data' => $data,
                );

                return response()->json($test, 200);
            }
        } else {
            $data = $this->users->searchByTypeForCompany('CUSTOMER', $companyID, $start, $length, $search);
            if (!empty($data)) {
                $this->log_viewer->logRequest($request);
                $test = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_user,
                    'recordsFiltered' => count($data),
                    'data' => $data,
                );

                return response()->json($test, 200);
            }
        }
        return response()->json([
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
        ], 200);
    }

    public function addUserCustomer(Request $request)
    {
        // $token = $request->cookie('token');
        // $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $data = [
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => $request->get('password'),
            'type_user' => 'CUSTOMER',
            'company_id' => $this->auth->user_company()->first()->company_id,
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
        ];

        $this->users->create($data);
        //$request->bearerToken(),201
        return response()->json(["status_code", "201"], 201);
    }

    public function getAllEmailCustomer(Request $request)
    {
        $data = $this->users->getAllEmailCustomer();
        return response()->json(compact('data'), 200);
    }

    public function addCustomerInCompany(Request $request)
    {
        $this->users->addCustomerInCompany($request->get('userList'));
    }

    public function countUserOnline(Request $request)
    {
        $type_user = $request->get('type_user');
        $company_id = $this->auth->user_company()->first()->company_id;
        $users = $this->users->countUserOnline($type_user, $company_id);
        return response()->json(compact('users'), 200);
    }

    public function getFileLogByFolder()
    {
        $folder_log = 'COMPANY_' . $this->auth->user_id;
        $file_log = $this->log_viewer->getFolderFilesV2($folder_log, true);
        return response()->json(compact('file_log'), 200);
    }

    public function getFileLog(Request $request)
    {
        $folder = $request->get('folder');
        $file = $request->get('file');
        $logs = $this->log_viewer->getLogsByFolders($folder, $file);
        $size = SizeLog::getSizeFile(storage_path('logs') . '/' . $folder . '/' . $file);
        $data = [
            'logs' => $logs,
            'current_folder' => $folder,
            'current_file' => $file,
            'size' => $size,
            'standardFormat' => true,
        ];
        return response()->json(compact('data'), 200);
    }

    // service
    public function addRegisWebService(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = $request->get('ServiceName') . "." . $companyID;

        $webService = TB_WEBSERVICE::create([
            'company_id' => $companyID,
            'service_name' => $request->get('ServiceName'),
            'service_name_DW' => $nameDW,
            'alias' => $request->get('alias'),
            'URL' => $request->get('strUrl'),
            'description' => $request->get('description'),
            'header_row' => $request->get('header'),
            'value_cal' => $request->get('valueCal'),
            'status' => $request->get('status'),
            'update_time' => $request->get('time'),
        ]);
        Log::info('Create Web Service - [] SUCCESS');
        return response()->json(compact('webService'), 200);
    }

    public function getWebServiceByCompany(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $data = $this->webservices->getWebServiceByCompany($companyID);
        return response()->json(compact('data'), 200);
    }

    public function getAllWebserviceData(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.status,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE TB_WEBSERVICE.company_id='$companyID'");

        if (empty($webService)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('webService'), 200);
    }

    public function getCompanyID(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;

        return response()->json(compact('companyID'), 200);
    }

    public function editRegisWebService(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = $request->get('ServiceName') . "." . $companyID;
        $webService = TB_WEBSERVICE::where('webservice_id', $request->get('idDB'))
            ->update([
                'service_name' => $request->get('ServiceName'),
                'service_name_DW' => $nameDW,
                'alias' => $request->get('alias'),
                'URL' => $request->get('strUrl'),
                'description' => $request->get('description'),
                'header_row' => $request->get('header'),
            ]);
        Log::info('Edit Web Service - [] SUCCESS');
        return response()->json(["status", "success"], 200);
    }

    public function deletewebservice(Request $request)
    {
        $webService = TB_WEBSERVICE::where('webservice_id', $request->get('id'))
            ->delete();
        Log::info('Delete Web Service - [] SUCCESS');
        return response()->json(["status", "success"], 200);
    }

    public function getKeyiot()
    {
        $key = 'klflvpekvlvep[clep[lc';
        return response()->json(compact('key'), 200);
    }

    //Static
    public function addStatic(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $message = $this->static->createStatic($request->get('name'), $companyID);

        return response()->json(["message", $message['message']], $message['status']);
    }

    public function updateStatic(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $this->static->updateStatic($request->get('static_id'), $request->get('name'), $companyID);
    }

    public function updateStaticDashboard(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $data = TB_STATIC::where('static_id', $request->get('static_id'))
            ->update(['dashboard' => $request->get('dashboard')]);
    }

    public function deleteStatic(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $this->static->deleteStatic($request->get('static_id'), $companyID);
    }

    public function getStaticDashboard(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;

        $data = $this->static->getStaticByCompanyId($companyID);
        return response()->json(compact('data'), 200);
    }

    public function getStaticDashboardById(Request $request, $static_id)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;
        $data = $this->static->getStaticDashboardById($static_id, $companyID);
        return response()->json(compact('data'), 200);
    }

    public function getDatasourceStatic(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $payload["user"]->company_id;
        $data = $this->static->getDatasoureByStaticId($request->get('static_id'), $companyID);
        return response()->json(compact('data'), 200);
    }

    public function addDatasourceStatic(Request $request)
    {
        $data = [
            'static_id' => $request->get('static_id'),
            'name' => $request->get('name'),
            'webservice_id' => $request->get('webservice_id'),
            'timeInterval' => $request->get('timeInterval'),
        ];
        $this->static->createDatasource($data);
    }
}
