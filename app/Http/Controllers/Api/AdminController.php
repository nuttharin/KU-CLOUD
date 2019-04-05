<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Gate;
use Mail;
use email;
use JWTAuth;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USERS;
use App\TB_STATIC;
use App\TB_COMPANY;
use App\TB_WEBSERVICE;
use App\TB_INFOGRAPHIC;
use App\Address_company;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use App\LogViewer\SizeLog;

use App\USER_FIRST_CREATE;
use App\LogViewer\LogViewer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_STATIC\StaticRepository;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;

class AdminController extends Controller
{
    private $users;

    private $log_viewer;

    private $company;

    private $auth;

    private $info;

    private $webservices;
    
    private $static;

    public function __construct(
    UsersRepository $users, 
    CompanyRepository $company, 
    InfographicRepository $info,
    WebServiceRepository $webservices,
    StaticRepository $static)
    {
        if (!Gate::allows('isAdmin')) {
            abort('403', "Sorry, You can do this actions");
        }

        $this->users = $users;
        $this->company = $company;
        $this->webservices = $webservices;
        $this->static = $static;

        $this->log_viewer = new LogViewer();
        $this->log_viewer->setFolder('KU_CLOUD');
       
        $this->info = $info;

        $this->auth = Auth::user();
    }

    public function getAllAdminister(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->users->getByTypeForAdmin('ADMIN');

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function createAdminister(Request $request)
    {
        $attributes = [
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'type_user' => 'ADMIN',
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
            // 'address' => $request->get('address'),
            // 'province' => $request->get('province'),
            // 'amphure' => $request->get('amphure'),
            // 'district' => $request->get('district'),
        ];

        $this->users->create($attributes);
        return response()->json(["status_code", "201"], 201);
    }

    public function editAdminister(Request $request)
    {
        $attributes = [
            'username' => $request->get('username'),
            'user_id' => $request->get('user_id'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
            'type_user' => $request->get('type_user'),
        ];
        $this->users->update($attributes);
        return response()->json(["status_code", "200"], 200);
    }

    public function getAllCompanies(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->users->getByTypeForAdmin('COMPANY');

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function createCompany(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $attributes = [
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'type_user' => 'COMPANY',
            'company_id' => $request->get('company_id'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
            // 'address' => $request->get('address'),
            // 'province' => $request->get('province'),
            // 'amphure' => $request->get('amphure'),
            // 'district' => $request->get('district'),
            'sub_type_user' => $request->get('sub_type_user'),
        ];

        $this->users->create($attributes);
        return response()->json(["status_code", "201"], 201);
    }

    public function editCompany(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        $attributes = [
            'username' => $request->get('username'),
            'user_id' => $request->get('user_id'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'phone_user' => $request->get('phone'),
            'email_user' => $request->get('email'),
            'sub_type_user' => $request->get('sub_type_user'),
            'company_id' => $request->get('company_id'),
            'type_user' => $request->get('type_user'),
        ];
        $this->users->update($attributes);

        return response()->json(["status_code", "201"], 201);
    }

    public function deleteCompany(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
            ->delete();
        $email = true;
        while ($email) {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $phone = true;
        while ($phone) {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->delete();

        return response()->json(["status", "success"], 200);
    }

    public function getAllCustomers(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $data = $this->users->getByTypeForAdmin('CUSTOMER');

        if (empty($data)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('data'), 200);
    }

    public function createCustomer(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $attributes = [
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'type_user' => 'CUSTOMER',
            'company_id' => $request->get('company_id'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
            // 'address' => $request->get('address'),
            // 'province' => $request->get('province'),
            // 'amphure' => $request->get('amphure'),
            // 'district' => $request->get('district'),
        ];
        //dd($attributes);
        $this->users->create($attributes);

        // $user = TB_USERS::create([
        //     'fname'     => $request->get('fname'),
        //     'lname'     => $request->get('lname'),
        //     'password'  => Hash::make($request->get('password')),
        //     'type_user' => 'CUSTOMER'
        // ]);

        // if($user->user_id)
        // {
        //     $user_company = TB_USER_CUSTOMER::create([
        //         'user_id'       => $user->user_id,
        //         'company_id'    => $request->get('company'),
        //     ]);

        //     $email = TB_EMAIL::create([
        //         'user_id'       => $user->user_id,
        //         'email_user'    => $request->get('email'),
        //         'is_verify'     => true,
        //     ]);

        //     $phone = TB_PHONE::create([
        //         'user_id'       => $user->user_id,
        //         'phone_user'    => $request->get('phone')
        //     ]);
        // }
        //$request->bearerToken(),201
        return response()->json(["status_code", "201"], 201);
    }

    public function editCustomer(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        $attributes = [
            'username' => $request->get('username'),
            'user_id' => $request->get('user_id'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'phone_user' => $request->get('phone'),
            'email_user' => $request->get('email'),
            'company_id' => $request->get('company_id'),
            'type_user' => $request->get('type_user'),
        ];
        $this->users->update($attributes);

        // $user = TB_USERS::where('user_id', $request->get('user_id'))
        //                     ->update([
        //                         'fname'     => $request->get('fname'),
        //                         'lname'     => $request->get('lname')
        //                     ]);

        // $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
        //                     ->delete();

        // $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
        //                     ->delete();

        // $arrayPhone = explode(",", $request->get('phone'));

        // if(!empty($arrayPhone[0]))
        // {
        //     $createP1 = TB_PHONE::create([
        //         'user_id'       => $request->get('user_id'),
        //         'phone_user'    => $arrayPhone[0]
        //     ]);
        // }

        // if(!empty($arrayPhone[1]))
        // {
        //     $createP2 = TB_PHONE::create([
        //         'user_id'       => $request->get('user_id'),
        //         'phone_user'    => $arrayPhone[1]
        //     ]);
        // }

        // if(!empty($arrayPhone[2]))
        // {
        //     $createP3 = TB_PHONE::create([
        //         'user_id'       => $request->get('user_id'),
        //         'phone_user'    => $arrayPhone[2]
        //     ]);
        // }

        // $arrayEmail = explode(",", $request->get('email'));

        // if(!empty($arrayEmail[0]))
        // {
        //     $createE1 = TB_EMAIL::create([
        //         'user_id'       => $request->get('user_id'),
        //         'email_user'    => $arrayEmail[0],
        //         'is_verify'     => false
        //     ]);
        // }

        // if(!empty($arrayEmail[1]))
        // {
        //     $createE1 = TB_EMAIL::create([
        //         'user_id'       => $request->get('user_id'),
        //         'email_user'    => $arrayEmail[1],
        //         'is_verify'     => false
        //     ]);
        // }

        // if(!empty($arrayEmail[2]))
        // {
        //     $createE1 = TB_EMAIL::create([
        //         'user_id'       => $request->get('user_id'),
        //         'email_user'    => $arrayEmail[2],
        //         'is_verify'     => false
        //     ]);
        // }

        // $userCompany = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
        //                                     ->update([
        //                                         'company_id'     => $request->get('company'),
        //                                     ]);

        return response()->json(["status_code", "201"], 201);
    }

    public function deleteCustomer(Request $request)
    {
        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
            ->delete();
        $email = true;
        while ($email) {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $phone = true;
        while ($phone) {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->delete();

        return response()->json(["status", "success"], 200);
    }

    public function getAllCompanyData(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $company = DB::select('SELECT TB_COMPANY.company_id, TB_COMPANY.company_name, alias, note, 
                                        ADDRESS_COMPANY.address_detail, ADDRESS_COMPANY.district_id, ADDRESS_COMPANY.amphure_id, ADDRESS_COMPANY.province_id,
                                        DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn, 
                                        AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn, 
                                        PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                FROM TB_COMPANY INNER JOIN ADDRESS_COMPANY ON ADDRESS_COMPANY.company_id = TB_COMPANY.company_id
                                INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_COMPANY.district_id
                                INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_COMPANY.amphure_id
                                INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_COMPANY.province_id');

        if (empty($company)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('company'), 200);
    }

    public function createCompanyData(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $company = TB_COMPANY::create([
            'company_name' => $request->get('company_name_input'),
            'alias' => $request->get('alias_input'),
            'note' => $request->get('note_input'),
        ]);

        $company_update = TB_COMPANY::where('company_id', $company->company_id)
        ->update([
            'folder_log' => 'COMPANY_'.$company->company_id,
        ]);

        $address_company = Address_company::insert([
            'company_id' => $company->company_id,
            'address_detail' => $request->get('address_detail'),
            'district_id' => $request->get('district'),
            'amphure_id' => $request->get('amphure'),
            'province_id' => $request->get('province'),
        ]);
        
        $attributes = [
            'username' => $request->get('accountname'),
            'fname' => $request->get('firstname'),
            'lname' => $request->get('lastname'),
            'type_user' => 'COMPANY',
            'company_id' => $company->company_id,
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone'),
            'sub_type_user' => 'ADMIN',
        ];

        $this->users->create($attributes);




        // $password = str_random(30);
        
        // $user = TB_USERS::create([
        //     'username' =>$request->get('accountname'),
        //     'fname' => $request->get('firstname'),
        //     'lname' => $request->get('lastname'),
        //     'password' => Hash::make($password),
        //     'type_user' => 'COMPANY',
        // ]);

        // $user_company = TB_USER_COMPANY::create([
        //     'user_id'       => $user->user_id,
        //     'is_user_main'  => 1,
        //     'company_id'    => $company->company_id,
        //     'sub_type_user'    => 'ADMIN',
        // ]);

        // $user_email = TB_EMAIL::create([
        //     'user_id' => $user->user_id,
        //     'email_user' => $request->get('email'),
        //     'is_verify' => false,
        //     'is_primary' => true,
        // ]);

        // $user_phone = TB_PHONE::create([
        //     'user_id' => $user->user_id,
        //     'phone_user' => $request->get('phone'),
        //     'is_primary' => true,
        // ]);

        // $user_first = USER_FIRST_CREATE::insert([
        //     'user_id' => $user->user_id,
        //     'token' => str_random(30),
        // ]);

        // $name = $user->fname . " " . $user->lname;
        // $email = $request->get('email');
        // $username = $request->get('accountname');

        // $verification_code = str_random(30); //Generate verification code
        // $subject = "Please verify your email address."; 
        
        // Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email,'username'=> $username,'password'=>$password],
        //     function($mail) use ($email, $name, $subject){
        //         $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD");
        //         $mail->to($email, $name);
        //         $mail->subject($subject);
        // });

        //$request->bearerToken(),201
        return response()->json(["status_code", "201"], 201);
    }

    public function editCompanyData(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $company = TB_COMPANY::where('company_id', $request->get('company_id_input'))
            ->update([
                'company_name' => $request->get('company_name_input'),
                'alias' => $request->get('alias_input'),
                'note' => $request->get('note_input'),
            ]);

        $address_company = Address_company::where('company_id', $request->get('company_id_input'))
            ->update([
                'address_detail' => $request->get('address_detail'),
                'district_id' => $request->get('district'),
                'amphure_id' => $request->get('amphure'),
                'province_id' => $request->get('province'),
            ]);

        //$request->bearerToken(),201
        return response()->json(["status_code", "201"], 201);
    }

    public function deleteCompanyData(Request $request)
    {
        $user = TB_COMPANY::where('company_id', $request->get('company_id'))
            ->delete();
        return response()->json(["status", "success"], 200);
    }

    /* Custom */
    public function getCountUsersByCompanyID(Request $request)
    {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $countCustomer = DB::table('TB_USER_CUSTOMER')
            ->where('company_id', $request->get('company_id'))
            ->count();
        $countCompany = DB::table('TB_USER_COMPANY')
            ->where('company_id', $request->get('company_id'))
            ->count();

        if ($countCompany + $countCustomer == 0) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function blockUser(Request $request)
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->update(['block' => $request->get('block')]);
        return response()->json(["status", "success"], 200);
    }

    public function unblockUser(Request $request)
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->update(['block' => false]);
        return response()->json(["status", "success"], 200);
    }

    public function deleteUser(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
            ->delete();

        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
            ->delete();

        $email = true;
        while ($email) {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $phone = true;
        while ($phone) {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
            ->delete();

        return response()->json(["status", "success"], 200);
    }

    public function countUserOnline(Request $request)
    {
        $type_user = $request->get('type_user');
        $users = $this->users->countUserOnline($type_user, 1);
        return response()->json(compact('users'), 200);
    }

    public function getLogList()
    {
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

        return response()->json(compact('data'), 200);
    }

    public function getFolderLogs()
    {
        $folder_log = $this->company->getCompanyFolderLog();
        return response()->json(compact('folder_log'), 200);
    }

    public function getFileLogByFolder(Request $request)
    {
        $folder_log = $request->get('folder_log');
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

    public function downloadFileLog(Request $request)
    {
        $folder = $request->get('folder');
        $file = $request->get('file');
        return $this->log_viewer->download($folder, $file);
    }

    public function deleteFileLog(Request $request)
    {
        $status = $this->log_viewer->deleteFileLog($request->get('folder'), $request->get('file_name'));
        return response()->json(compact('status'), 200);
    }

    public function delelteFileLogByFolder(Request $request)
    {
        $status = $this->log_viewer->delelteFileLogByFolder($request->get('folder'));
        return response()->json(compact('status'), 200);
    }

    public function getCompanyID(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        return response()->json(compact('companyID'), 200);
    }

    public function addRegisWebService(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = $request->get('ServiceName') . "." . $companyID;
        // $userID = $this->auth->user_id;
        // $data = [
        //     "status" =>$userID,
        // ];

        $webService = TB_WEBSERVICE::create([
            'company_id' => $companyID,
            'service_name' => $request->get('ServiceName'),
            'service_name_DW' => $nameDW,
            'alias' => $request->get('alias'),
            'URL' => $request->get('strUrl'),
            'description' => $request->get('description'),
            'header_row' => $request->get('header'),
        ]);
        return response()->json(compact('webService'), 200);
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
        return response()->json(["status", "success"], 200);
    }

    public function getAllWebserviceData(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        $webService = DB::select("SELECT TB_WEBSERVICE.webservice_id as id,TB_WEBSERVICE.company_id,TB_WEBSERVICE.service_name as name,TB_WEBSERVICE.service_name_DW,TB_WEBSERVICE.alias,TB_WEBSERVICE.URL,TB_WEBSERVICE.description,TB_WEBSERVICE.header_row,TB_WEBSERVICE.created_at,TB_WEBSERVICE.updated_at
        FROM TB_WEBSERVICE WHERE TB_WEBSERVICE.company_id='$companyID'");

        if (empty($webService)) {
            return response()->json(['message' => 'not have data'], 200);
        }

        return response()->json(compact('webService'), 200);
    }
    public function deletewebservice(Request $request)
    {
        $webService = TB_WEBSERVICE::where('webservice_id', $request->get('id'))
            ->delete();
        return response()->json(["status", "success"], 200);
    }

    //Static
    public function getWebServiceByCompany(Request $request)
    {
        $companyID =  $this->auth->user_company()->first()->company_id;

        $data = $this->webservices->getWebServiceByCompany($companyID);
        return response()->json(compact('data'), 200);
    }

    public function addStatic(Request $request)
    {
        $message = $this->static->createStatic($request->get('name'));

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
        $data = TB_STATIC::where('static_id', $request->get('static_id'))
            ->update(['dashboard' => $request->get('dashboard')]);
    }

    public function deleteStatic(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;

        $this->static->deleteStatic($request->get('static_id'), $companyID);
    }

    public function getStaticDashboard(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;

        $data = $this->static->getStaticByCompanyId($companyID);
        return response()->json(compact('data'), 200);
    }

    public function getStaticDashboardById(Request $request, $static_id)
    {

        $companyID = Auth::user()->user_company()->first()->company_id;
        $data = $this->static->getStaticDashboardById($static_id, $companyID);
        return response()->json(compact('data'), 200);
    }

    public function getDatasourceStatic(Request $request)
    {
        $companyID = Auth::user()->user_company()->first()->company_id;
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

    public function deleteDatasourceByStatic(Request $request){
        $static_id = $request->get('static_id');
        $id = $request->get('id');
        $this->static->deleteDatasourceByStatic($static_id,$id);
    }

    // public function getAllInfograpic(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();
    //     $data = $this->info->getInfographicByUserID($payload["sub"]);

    //     if (empty($data)) {
    //         return response()->json(['message' => 'not have data'], 200);
    //     }

    //     return response()->json(compact('data'), 200);
    // }

    // public function getInfograpicData(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();
    //     $data = $this->info->getInfographicByInfoID($request->get('info_id'));

    //     if (empty($data)) {
    //         return response()->json(['message' => 'not have data'], 200);
    //     }

    //     return response()->json(compact('data'), 200);
    // }

    // public function createInfograpic(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();

    //     $addinfo = TB_INFOGRAPHIC::create([
    //         'user_id' => $payload["sub"],
    //         'name' => $request->get('name'),
    //     ]);

    //     return response()->json(["status_code", "201"], 201);
    // }

    // public function updateInfograpic(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();

    //     $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
    //         ->update([
    //             'name' => $request->get('name'),
    //         ]);

    //     return response()->json(["status_code", "201"], 201);
    // }

    // public function updateInfograpicData(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();

    //     $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
    //         ->update([
    //             'info_data' => $request->get('info_data'),
    //         ]);

    //     return response()->json(["status_code", "201"], 201);
    // }

    // public function deleteInfograpic(Request $request)
    // {
    //     $info = TB_INFOGRAPHIC::where('info_id', $request->get('info_id'))
    //         ->delete();
    //     return response()->json(["status", "success"], 200);
    // }

    // public function addDatasourceInfo(Request $request)
    // {
    //     $data = [
    //         'info_id' => $request->get('info_id'),
    //         'name' => $request->get('name'),
    //         'webservice_id' => $request->get('webservice_id'),
    //         'timeInterval' => $request->get('timeInterval'),
    //     ];
    //     $this->info->createInfoDatasource($data);
    // }

    // public function getDatasourceInfo(Request $request)
    // {
    //     $token = $request->cookie('token');
    //     $payload = JWTAuth::setToken($token)->getPayload();
    //     $data = $this->info->getInfoDatasourceByInfoID($request->get('info_id'));

    //     if (empty($data)) {
    //         return response()->json(['message' => 'not have data'], 200);
    //     }

    //     return response()->json(compact('data'), 200);
    // }
}
