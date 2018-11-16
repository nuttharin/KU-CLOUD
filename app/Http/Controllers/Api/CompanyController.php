<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UsersRequest;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_USERS\UsersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use JWTAuth;
use DB;
use App\TB_USERS;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use App\TB_WEBSERVICE;
use App\TB_REGISTER_WEBSERVICE;

use email;
use Mail;
use Illuminate\Mail\Message;

use App\LogViewer\LogViewer;

use Auth;

use Log;
use App\LogViewer\SizeLog;

use Gate;
class CompanyController extends Controller
{
    /**
     * @var UsersRepository
     */
    private $users;
    private $companies;
    private $auth;

    public  function __construct(UsersRepository $users,CompanyRepository $companies,Request $request)
    {
        if(!Gate::allows('isCompanyAdmin')){
            abort('403',"Sorry, You can do this actions");
        }
        
        $this->users = $users;
        $this->companies = $companies;

        $this->log_viewer = new LogViewer();
        
        $this->auth = Auth::user();
        $company_id = $this->auth->user_company()->first()->company_id;
        $this->log_viewer->setFolder('COMPANY_'.$company_id);
    }

    public function test(){
        return response()->json(["test"=>'1234'],201);
    }

    public function getAllUser(Request $request){
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();

        $data = $this->users->getByTypeForCompany('COMPANY',$payload["user"]->company_id);
        if(!empty($data)){
            $this->log_viewer->logRequest($request);
            return response()->json(compact('data'),200);
        }
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUserCompany(UsersRequest $request) {
        $token = $request->cookie('token');
        $payload = JWTAuth::setToken($token)->getPayload();
        
        $data = [
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'password' => $request->get('password'),
            'type_user' => 'COMPANY',
            'company_id' => $payload["user"]->company_id,
            'sub_type_user' => $request->get('sub_type_user'),
            'email_user' => $request->get('email'),
            'phone_user' => $request->get('phone')
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

        return response()->json(["status_code","201"],201);
    }

    public function editUserCompany(Request $request){
        $data = [
            'user_id' => $request->get('user_id'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'phone_user' => $request->get('phone_user'),
            'email_user' => $request->get('email_user')
        ];
        $this->users->update($data);
    }

    public function blockUserCompany(Request $request){
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                        ->update(['block' => $request->get('block')]);
        return response()->json(["status","success"],200);
    }

    public function getAllCustomer(Request $request){
        // $token = $request->cookie('token');
        // $payload = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $data = $this->users->getByTypeForCompany('CUSTOMER',$this->auth->user_company()->first()->company_id);
        if(!empty($data)){
            $this->log_viewer->logRequest($request);
            return response()->json(compact('data'),200);
        }
        return response()->json(['message' => 'not have data'],200);
    }

    public function addUserCustomer(Request $request){
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
            'phone_user' => $request->get('phone')
        ];

        $this->users->create($data);
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function countUserOnline(Request $request){
        $type_user = $request->get('type_user');
        $company_id = $this->auth->user_company()->first()->company_id;
        $users = $this->users->countUserOnline($type_user, $company_id);
        return response()->json(compact('users'),200);
    }

    public  function getFileLogByFolder(){
        $folder_log = 'COMPANY_'.$this->auth->user_id;
        $file_log = $this->log_viewer->getFolderFilesV2($folder_log,true);
        return response()->json(compact('file_log'),200);
    }

    public  function getFileLog(Request $request){
        $folder = $request->get('folder');
        $file = $request->get('file');
        $logs = $this->log_viewer->getLogsByFolders($folder,$file);
        $size = SizeLog::getSizeFile(storage_path('logs').'/'.$folder.'/'.$file);
        $data = [
            'logs' => $logs,
            'current_folder' => $folder,
            'current_file' => $file,
            'size'=>$size,
            'standardFormat' => true,
        ];
        return response()->json(compact('data'),200);
    }

    public function addRegisWebService(Request $request){
        $companyID = $this->auth->user_company()->first()->company_id;
        $nameDW = $request->get('ServiceName').".".$companyID;
        
        
        $webService = TB_WEBSERVICE::create([
            'company_id'=>$companyID,
            'service_name' => $request->get('ServiceName'),	
            'service_name_DW' => $nameDW,	
            'alias' =>$request->get('alias'),
            'URL'=> $request->get('strUrl'),
            'description'=> $request->get('description'),
            'header_row'=> $request->get('header'),
        ]);
       
        return response()->json(compact('webService'),200);
    }

    public function getCompanyID(Request $request){
        $companyID = $this->auth->user_company()->first()->company_id;
        return response()->json(compact('companyID'),200);

    }


    
}
