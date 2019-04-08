<?php

namespace App\Http\Controllers\Api;

use App\Address_company;
use App\Http\Controllers\Controller;
use App\LogViewer\LogViewer;
use App\LogViewer\SizeLog;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_STATIC\StaticRepository;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
use App\TB_COMPANY;
use App\TB_WEBSERVICE;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Image;
use JWTAuth;
use Log;
use Response;

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

        // if (!Gate::allows('isCompanyAdmin')) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->users = $users;
        $this->companies = $companies;
        $this->webservices = $webservices;
        $this->static = $static;

        $this->log_viewer = new LogViewer();

        $this->middleware('jwt.verify');
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            $company_id = $this->auth->user_company()->first()->company_id;
            if ( $this->auth->type_user == "COMPANY") {
                $this->log_viewer->setFolder('COMPANY_' . $company_id);
            } else if ( $this->auth->type_user == "ADMIN") {
                $this->log_viewer->setFolder('KU_CLOUD');
            }
            return $next($request);
        });

    }

    public function test()
    {
        $user = $this->auth;
        return response()->json(compact('user'), 201);
    }

    public function getCompanyById()
    {
        $data = $this->companies->getCompanyById(Auth::user()->user_company()->first()->company_id);
        return response()->json(compact('data'), 201);
    }

    public function updateCompanyId(Request $request)
    {
        $attr = [
            'company_name_input' => $request->get('company_name_input'),
            'alias_input' => $request->get('alias_input'),
            'note_input' => $request->get('note_input'),
            'address_detail' => $request->get('address_detail'),
            'district' => $request->get('district'),
            'amphure' => $request->get('amphure'),
            'province' => $request->get('province'),
        ];

        $data = $this->companies->updateCompanyId($attr, Auth::user()->user_company()->first()->company_id);
        return response()->json(compact('data'), 201);
    }

    // public function getAllUser(Request $request)
    // {
    //     $columns = array(
    //         0 => 'fname',
    //         1 => 'phone_user',
    //         2 => 'email_user',
    //         3 => 'block',
    //         4 => 'sub_type_user',
    //         5 => 'online',
    //     );
    //     $companyID = $this->auth->user_company()->first()->company_id;
    //     $draw = $request->input('draw');
    //     $start = $request->input('start');
    //     $length = $request->input('length');
    //     $search = $request->input('search.value');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');
    //     $total_user = $this->users->countUser('COMPANY', $companyID)[0]->count;

    //     if (empty($search)) {
    //         $data = $this->users->getByTypeForCompany('COMPANY', $companyID, $start, $length, $order, $dir);

    //         if (!empty($data)) {
    //             $this->log_viewer->logRequest($request);
    //             $test = array(
    //                 'draw' => $draw,
    //                 'recordsTotal' => $total_user,
    //                 'recordsFiltered' => $total_user,
    //                 'data' => $data,
    //             );

    //             return response()->json($test, 200);
    //         }
    //     } else {
    //         $data = $this->users->searchByTypeForCompany('COMPANY', $companyID, $start, $length, $search, $order, $dir);
    //         if (!empty($data)) {
    //             $this->log_viewer->logRequest($request);
    //             $test = array(
    //                 'draw' => $draw,
    //                 'recordsTotal' => $total_user,
    //                 'recordsFiltered' => count($data),
    //                 'data' => $data,
    //             );

    //             return response()->json($test, 200);
    //         }
    //     }
    //     return response()->json([
    //         'draw' => 0,
    //         'recordsTotal' => 0,
    //         'recordsFiltered' => 0,
    //         'data' => [],
    //     ], 200);
    // }

    // public function addUserCompany(Request $request)
    // {
    //     $data = [
    //         'username' => $request->get('username'),
    //         'fname' => $request->get('fname'),
    //         'lname' => $request->get('lname'),
    //         // 'password' => $request->get('password'),
    //         'type_user' => 'COMPANY',
    //         'company_id' => $this->auth->user_company()->first()->company_id,
    //         'sub_type_user' => $request->get('sub_type_user'),
    //         'email_user' => $request->get('email'),
    //         'phone_user' => $request->get('phone'),
    //     ];

    //     $this->users->create($data);

    //     // $name = $request->get('fname')." ".$request->get('lname');
    //     // $email = $request->get('email');

    //     // $verification_code = str_random(30); //Generate verification code

    //     // DB::table('USER_VERIFICATIONS')->insert(['user_id'=>$user->user_id,'token'=>$verification_code]);
    //     // $subject = "Please verify your email address.";
    //     // Mail::send('auth.verify', ['name' => $name, 'verification_code' => $verification_code,'email' => $email],
    //     //     function($mail) use ($email, $name, $subject){
    //     //         $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD Name Goes Here");
    //     //         $mail->to($email, $name);
    //     //         $mail->subject($subject);
    //     // });

    //     //$request->bearerToken(),201

    //     return response()->json(["status_code", "201"], 201);
    // }

    // public function editUserCompany(Request $request)
    // {
    //     $data = [
    //         'user_id' => $request->get('user_id'),
    //         'fname' => $request->get('fname'),
    //         'lname' => $request->get('lname'),
    //         'phone_user' => $request->get('phone_user'),
    //         'email_user' => $request->get('email_user'),
    //     ];
    //     $this->users->update($data);
    // }

    // public function deleteEmailUser(Request $request)
    // {
    //     $data = [
    //         'email_user' => $request->get('email_user'),
    //     ];
    //     $this->users->deleteEmailUser($data);
    // }

    // public function deletePhoneUser(Request $request)
    // {
    //     $data = [
    //         'phone_user' => $request->get('phone_user'),
    //     ];
    //     $this->users->deletePhoneUser($data);
    // }

    // public function blockUserCompany(Request $request)
    // {
    //     $user = TB_USERS::where('user_id', $request->get('user_id'))
    //         ->update(['block' => $request->get('block')]);
    //     return response()->json(["status", "success"], 200);
    // }

    // public function getAllCustomer(Request $request)
    // {
    //     $columns = array(
    //         0 => 'fname',
    //         1 => 'phone_user',
    //         2 => 'email_user',
    //         3 => 'block',
    //         4 => 'online',
    //     );
    //     $companyID = $this->auth->user_company()->first()->company_id;
    //     $draw = $request->input('draw');
    //     $start = $request->input('start');
    //     $length = $request->input('length');
    //     $search = $request->input('search.value');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');
    //     $total_user = $this->users->countUser('CUSTOMER', $companyID)[0]->count;

    //     if (empty($search)) {
    //         $data = $this->users->getByTypeForCompany('CUSTOMER', $companyID, $start, $length, $order, $dir);
    //         if (!empty($data)) {
    //             $this->log_viewer->logRequest($request);
    //             $test = array(
    //                 'draw' => $draw,
    //                 'recordsTotal' => $total_user,
    //                 'recordsFiltered' => $total_user,
    //                 'data' => $data,
    //             );

    //             return response()->json($test, 200);
    //         }
    //     } else {
    //         $data = $this->users->searchByTypeForCompany('CUSTOMER', $companyID, $start, $length, $search, $order, $dir);
    //         if (!empty($data)) {
    //             $this->log_viewer->logRequest($request);
    //             $test = array(
    //                 'draw' => $draw,
    //                 'recordsTotal' => $total_user,
    //                 'recordsFiltered' => count($data),
    //                 'data' => $data,
    //             );

    //             return response()->json($test, 200);
    //         }
    //     }
    //     return response()->json([
    //         'draw' => 0,
    //         'recordsTotal' => 0,
    //         'recordsFiltered' => 0,
    //         'data' => [],
    //     ], 200);
    // }

    // public function addUserCustomer(Request $request)
    // {
    //     // $token = $request->cookie('token');
    //     // $payload = JWTAuth::setToken($token)->getPayload();
    //     //dd($payload["user"]->company_id);

    //     $data = [
    //         'username' => $request->get('username'),
    //         'fname' => $request->get('fname'),
    //         'lname' => $request->get('lname'),
    //         'type_user' => 'CUSTOMER',
    //         'company_id' => $this->auth->user_company()->first()->company_id,
    //         'email_user' => $request->get('email'),
    //         'phone_user' => $request->get('phone'),
    //     ];

    //     $this->users->create($data);
    //     //$request->bearerToken(),201
    //     return response()->json(["status_code", "201"], 201);
    // }

    // public function getAllEmailCustomer(Request $request)
    // {
    //     $data = $this->users->getAllEmailCustomer();
    //     return response()->json(compact('data'), 200);
    // }

    // public function addCustomerInCompany(Request $request)
    // {
    //     $this->users->addCustomerInCompany($request->get('userList'));
    // }

    // public function countUserOnline(Request $request)
    // {
    //     $type_user = $request->get('type_user');
    //     $company_id = $this->auth->user_company()->first()->company_id;
    //     $users = $this->users->countUserOnline($type_user, $company_id);
    //     return response()->json(compact('users'), 200);
    // }

    public function uploadLogo(Request $request)
    {
        DB::beginTransaction();
        $company_id = Auth::user()->user_company()->first()->company_id;
        $img_logo = TB_COMPANY::where('company_id','=',$company_id)->first()->img_logo;
        try {
            if ($request->get('img_logo') != '') {
                if ($img_logo != 'default-logo.jpg') {
                    $path = storage_path('app/uploadLogoCompany/' . $img_logo);
                    File::delete($path);
                }

                $data = $request->get('img_logo');
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $imageName = str_random(10) . '.' . 'png';
                \File::put(storage_path() . '/app/uploadLogoCompany/' . $imageName, $data);

                $img = Image::make(storage_path('app/uploadLogoCompany/' . $imageName));
                $img->resize(400, 400);
                $img->save();

                TB_COMPANY::where('company_id','=',$company_id)->update([
                    'img_logo' => $imageName,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(compact('image'), 200);
    }

   
    public function getFileLogByFolder()
    {
        $folder_log = 'COMPANY_' . $this->auth->user_company()->first()->company_id;
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
        $company_id = Auth::user()->user_company()->first()->company_id;
        $path = storage_path('logs/' . "COMPANY_$company_id/".$request->get('file_name'));
        if (!File::exists($path)) {
            \abort(404);
        }

        return response()->download($path);
    }

    public function deleteFileLog(Request $request)
    {
        $company_id = Auth::user()->user_company()->first()->company_id;
        $path = storage_path('logs/' . "COMPANY_$company_id/".$request->get('file_name'));
        if (!File::exists($path)) {
            \abort(404);
        }
        else{
            $status = $this->log_viewer->deleteFileLog("COMPANY_$company_id", $request->get('file_name'));
            return response()->json(compact('status'), 200);
        }
    }

    // service
    public function addRegisWebService(Request $request)
    {
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = "WebService.".$request->get('ServiceName') . "." . $companyID;

        $webService = TB_WEBSERVICE::create([
            'company_id' => $companyID,
            'service_name' => $request->get('ServiceName'),
            'service_name_DW' => $nameDW,
            'alias' => $request->get('alias'),
            'URL' => $request->get('strUrl'),
            'description' => $request->get('description'),
            'header_row' => $request->get('header'),
            'value_array' => $request->get('strArr'),
            'value_cal' => $request->get('valueCal'),
            'value_groupby' => $request->get('valueGroup'),
            'status' => $request->get('status'),
            'update_time' => $request->get('time'),
            'example_data' => "xxxx",
        ]);
        Log::info('Create Web Service - [] SUCCESS');
        return response()->json(compact('webService'), 200);
    }

    public function getWebServiceByCompany(Request $request)
    {
        return $this->webservices->getWebServiceByCompany();
    }

    public function getAllWebserviceData(Request $request)
    {
        // $token = $request->bearerToken();
        // $payload = JWTAuth::setToken($token)->getPayload();
        $companyID = $this->auth->user_company()->first()->company_id;
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

    public function downloadJSONFile(Request $request)
    {
        // $detail_tryit = $request->get('jsondata');
        // $data = json_encode($detail_tryit);
        // $fileName = time() . '_datafile.json';
        // $headers = ['Content-Type' => 'application/่json',];
        // return response()->json(compact('data'),200);

        $detail_tryit = $request->get('jsondata');
        $filename = json_encode($detail_tryit);
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        return response()->download($tempImage, $filename);

        // $detail_tryit = $request->get('jsondata');
        // $data = json_encode($detail_tryit);
        // $fileName = time() . '_datafile.json';
        // File::put(public_path('/upload/json/'.$fileName),$data);
        // $headers = ['Content-Type' => 'application/่json',];
        // return response()->download(File::put(public_path('/upload/json/'.$fileName),$data), $filename, $headers);

        // $detail_tryit = $request->get('jsondata');
        // $data = json_encode($detail_tryit);
        // $fileName = time() . '_datafile.json';
        // File::put(public_path('/upload/json/'.$fileName),$data);
        // return Response::download(public_path('/upload/jsonfile/'.$fileName));
    }

    // iot service
    // public function getAllIotserviceData(Request $request)
    // {
    //     $token = $request->bearerToken();
    //     $payload = JWTAuth::setToken($token)->getPayload();
    //     $companyID =  $this->auth->user_company()->first()->company_id;
    //     $iotService = DB::select("SELECT TB_IOTSERVICE.iotservice_id as id,TB_IOTSERVICE.company_id as idCompany,TB_IOTSERVICE.iot_name as name,TB_IOTSERVICE.iot_name_DW,TB_IOTSERVICE.alias,TB_IOTSERVICE.API,TB_IOTSERVICE.description,TB_IOTSERVICE.value_cal,TB_IOTSERVICE.status,TB_IOTSERVICE.created_at,TB_IOTSERVICE.updated_at
    //     FROM TB_IOTSERVICE WHERE TB_IOTSERVICE.company_id='$companyID'");

    //     if (empty($iotService)) {
    //         return response()->json(['message' => 'not have data'], 200);
    //     }

    //     return response()->json(compact('iotService'), 200);

    // }

    // public function getKeyiot()
    // {
    //     $key = 'klflvpekvlvep[clep[lc';
    //     return response()->json(compact('key'), 200);
    // }

    // public function addRegisIotService(Request $request)
    // {
    //     $companyID = $this->auth->user_company()->first()->company_id;
    //     $nameDW = $request->get('ServiceName') . "." . $companyID;

    //     $iotService = TB_IOTSERVICE::create([
    //         'company_id' => $companyID,
    //         'iot_name' => $request->get('ServiceName'),
    //         'iot_name_DW' => $nameDW,
    //         'type' => $request->get('type'),
    //         'alias' => $request->get('alias'),
    //         'description' => $request->get('description'),
    //         'status' => $request->get('stats'),
    //         'url_onoff_input' => $request->get('strUrl'),
    //         'dataformat' => $request->get('datajson'),
    //         'value_cal' => $request->get('valueCal'),
    //         'value_gropby' => $request->get('valueGroupby'),
    //         // 'updatetime_input' => $request->get('updatetime_input'),
    //     ]);
    //     Log::info('Create Web Service - [] SUCCESS');
    //     return response()->json(compact('iotService'), 200);
    // }
    // public function addOutputRegisIotService(Request $request)
    // {
    //     $companyID = $this->auth->user_company()->first()->company_id;
    //     $nameDW = $request->get('ServiceName') . "." . $companyID;

    //     $iotService = TB_IOTSERVICE::create([
    //         'company_id' => $companyID,
    //         'iot_name' => $request->get('ServiceName'),
    //         'iot_name_DW' => $nameDW,
    //         'type' => $request->get('type'),
    //         'alias' => $request->get('alias'),
    //         'description' => $request->get('description'),
    //         'status' => $request->get('stats'),
    //         'url_onoff_output' => $request->get('strUrl'),
    //         'pins_onoff' => $request->get('pinfilds'),
    //         'value_cal' => $request->get('valueCal'),
    //     ]);
    //     Log::info('Create Web Service - [] SUCCESS');
    //     return response()->json(compact('iotService'), 200);
    // }
    //Static
    // public function addStatic(Request $request)
    // {
    //     $message = $this->static->createStatic($request->get('name'));

    //     return response()->json(["message", $message['message']], $message['status']);
    // }

    // public function updateStatic(Request $request)
    // {
    //     $token = $request->bearerToken();
    //     $payload = JWTAuth::setToken($token)->getPayload();
    //     $companyID = $payload["user"]->company_id;

    //     $this->static->updateStatic($request->get('static_id'), $request->get('name'), $companyID);
    // }

    // public function updateStaticDashboard(Request $request)
    // {
    //     $data = TB_STATIC::where('static_id', $request->get('static_id'))
    //         ->update(['dashboard' => $request->get('dashboard')]);
    // }

    // public function deleteStatic(Request $request)
    // {
    //     $companyID = Auth::user()->user_company()->first()->company_id;

    //     $this->static->deleteStatic($request->get('static_id'), $companyID);
    // }

    // public function getStaticDashboard(Request $request)
    // {
    //     $companyID = Auth::user()->user_company()->first()->company_id;

    //     $data = $this->static->getStaticByCompanyId($companyID);
    //     return response()->json(compact('data'), 200);
    // }

    // public function getStaticDashboardById(Request $request, $static_id)
    // {

    //     $companyID = Auth::user()->user_company()->first()->company_id;
    //     $data = $this->static->getStaticDashboardById($static_id, $companyID);
    //     return response()->json(compact('data'), 200);
    // }

    // public function getDatasourceStatic(Request $request)
    // {
    //     $companyID = Auth::user()->user_company()->first()->company_id;
    //     $data = $this->static->getDatasoureByStaticId($request->get('static_id'), $companyID);
    //     return response()->json(compact('data'), 200);
    // }

    // public function addDatasourceStatic(Request $request)
    // {
    //     $data = [
    //         'static_id' => $request->get('static_id'),
    //         'name' => $request->get('name'),
    //         'webservice_id' => $request->get('webservice_id'),
    //         'timeInterval' => $request->get('timeInterval'),
    //     ];
    //     $this->static->createDatasource($data);
    // }

    // public function deleteDatasourceByStatic(Request $request){
    //     $static_id = $request->get('static_id');
    //     $id = $request->get('id');
    //     $this->static->deleteDatasourceByStatic($static_id,$id);
    // }

    /* Admin */
    public function getAllCompanyData(Request $request)
    {
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
        $company = TB_COMPANY::create([
            'company_name' => $request->get('company_name_input'),
            'alias' => $request->get('alias_input'),
            'note' => $request->get('note_input'),
        ]);

        $company_update = TB_COMPANY::where('company_id', $company->company_id)
            ->update([
                'folder_log' => 'COMPANY' . '_' . $company->company_id,
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
            'admincheck' => $request->get('admincheck'),
        ];

        $this->users->create($attributes);

        return response()->json(["status_code", "201"], 201);
    }

    public function editCompanyData(Request $request)
    {

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

        return response()->json(["status_code", "201"], 201);
    }

    public function deleteCompanyData(Request $request)
    {
        $user = TB_COMPANY::where('company_id', $request->get('company_id'))
            ->delete();
        return response()->json(["status", "success"], 200);
    }

    public function getCountUsersByCompanyID(Request $request)
    {
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
}
