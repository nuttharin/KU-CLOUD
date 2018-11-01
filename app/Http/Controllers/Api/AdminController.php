<?php

namespace App\Http\Controllers\Api;

use App\LogViewer\SizeLog;
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
use App\TB_COMPANY;
use App\LogViewer\LogViewer;
use email;
use Mail;
use Illuminate\Mail\Message;


class AdminController extends Controller
{
    private $users;

    private $log_viewer;

    private $company;

    public  function __construct(UsersRepository $users,CompanyRepository $company)
    {
        $this->users = $users;
        $this->log_viewer = new LogViewer();
        $this->log_viewer->setFolder('KU_CLOUD');
        $this->company = $company;
    }

    public function getAllAdminister(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users      = $this->users->getByTypeForAdmin('ADMIN');

        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createAdminister(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);

        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => $request->get('type_user')
        ]);
        
        if($user->user_id)
        {
            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => false
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }

        return response()->json(["status_code","201"],201);
    }

    public function editAdminister(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }
        
        return response()->json(["status_code","201"],201);
    }

    public function getAllCompanies(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users      = $this->users->getByTypeForAdmin('COMPANY');

        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createCompany(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => 'COMPANY'
        ]);
        
        if($user->user_id)
        {
            $user_company = TB_USER_COMPANY::create([
                'user_id'       => $user->user_id,
                'company_id'    => $payload["user"]->company_id,
                'sub_type_user' => $request->get('sub_type_user')
            ]);

            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => false,
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function editCompany(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }

        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->update([
                                                'company_id'     => $request->get('company'),
                                                'sub_type_user'  => $request->get('sub_type_user')
                                            ]);
        
        return response()->json(["status_code","201"],201);
    }

    public function deleteCompany(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->delete();
        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function getAllCustomers(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $users   = $this->users->getByTypeForAdmin('CUSTOMER');
        
        if(empty($users))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('users'),200);
    }

    public function createCustomer(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::create([
            'fname'     => $request->get('fname'),
            'lname'     => $request->get('lname'),
            'password'  => Hash::make($request->get('password')),
            'type_user' => 'CUSTOMER'
        ]);
        
        if($user->user_id)
        {
            $user_company = TB_USER_CUSTOMER::create([
                'user_id'       => $user->user_id,
                'company_id'    => $request->get('company'),
            ]);

            $email = TB_EMAIL::create([
                'user_id'       => $user->user_id,
                'email_user'    => $request->get('email'),
                'is_verify'     => true,
            ]);

            $phone = TB_PHONE::create([
                'user_id'       => $user->user_id,
                'phone_user'    => $request->get('phone')
            ]);
        }
        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function editCustomer(Request $request) 
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update([
                                'fname'     => $request->get('fname'),
                                'lname'     => $request->get('lname')
                            ]);

        $delPhone = TB_PHONE::where('user_id', $request->get('user_id'))
                            ->delete();

        $delEmail = TB_EMAIL::where('user_id', $request->get('user_id'))
                            ->delete();
        
        $arrayPhone = explode(",", $request->get('phone'));

        if(!empty($arrayPhone[0]))
        {
            $createP1 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[0]
            ]);
        }

        if(!empty($arrayPhone[1]))
        {
            $createP2 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[1]
            ]);
        }

        if(!empty($arrayPhone[2]))
        {
            $createP3 = TB_PHONE::create([
                'user_id'       => $request->get('user_id'),
                'phone_user'    => $arrayPhone[2]
            ]);
        }

        $arrayEmail = explode(",", $request->get('email'));

        if(!empty($arrayEmail[0]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[0],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[1]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[1],
                'is_verify'     => false
            ]);
        }

        if(!empty($arrayEmail[2]))
        {
            $createE1 = TB_EMAIL::create([
                'user_id'       => $request->get('user_id'),
                'email_user'    => $arrayEmail[2],
                'is_verify'     => false
            ]);
        }

        $userCompany = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->update([
                                                'company_id'     => $request->get('company'),
                                            ]);
        
        return response()->json(["status_code","201"],201);
    }

    public function deleteCustomer(Request $request)
    {
        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->delete();
        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function getAllCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $company    = DB::select('SELECT TB_COMPANY.company_id as id, TB_COMPANY.company_name as name, TB_COMPANY.alias, TB_COMPANY.address, TB_COMPANY.note, TB_COMPANY.created_at, TB_COMPANY.updated_at 
                                    FROM TB_COMPANY');
        
        if(empty($company))
        {           
            return response()->json(['message' => 'not have data'],200);
        }
        
        return response()->json(compact('company'),200);
    }

    public function createCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $company = TB_COMPANY::create([
            'company_name'  => $request->get('company_name'),
            'alias'         => $request->get('alias'),
            'address'       => $request->get('address'),
            'note'          => $request->get('note')
        ]);

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function editCompanyData(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        //dd($payload["user"]->company_id);
        
        $company = TB_COMPANY::where('company_id', $request->get('company_id'))
                            ->update([
                                'company_name'  => $request->get('company_name'),
                                'alias'         => $request->get('alias'),
                                'address'       => $request->get('address'),
                                'note'          => $request->get('note')
                            ]);

        //$request->bearerToken(),201
        return response()->json(["status_code","201"],201);
    }

    public function deleteCompanyData(Request $request)
    {
        $user = TB_COMPANY::where('company_id', $request->get('company_id'))
                                ->delete();
        return response()->json(["status","success"],200);
    }

    /* Custom */
    public function getCountUsersByCompanyID(Request $request)
    {
        $token      = $request->cookie('token');
        $payload    = JWTAuth::setToken($token)->getPayload();
        $countCustomer   = DB::table('TB_USER_CUSTOMER')
                            ->where('company_id', $request->get('company_id'))
                            ->count();
        $countCompany    = DB::table('TB_USER_COMPANY')
                            ->where('company_id', $request->get('company_id'))
                            ->count();
        
        if($countCompany + $countCustomer == 0)
        {
            return response()->json(true, 200);
        }
        else
        {
            return response()->json(false, 200);
        }
    }
    
    public function blockUser(Request $request) 
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update(['block' => true]);
        return response()->json(["status","success"],200);
    }

    public function unblockUser(Request $request) 
    {
        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->update(['block' => false]);
        return response()->json(["status","success"],200);
    }

    public function deleteUser(Request $request)
    {
        $userCompany = TB_USER_COMPANY::where('user_id', $request->get('user_id'))
                                            ->delete();
        
        $userCustomer = TB_USER_CUSTOMER::where('user_id', $request->get('user_id'))
                                            ->delete();

        $email = true;
        while($email)
        {
            $email = TB_EMAIL::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $phone = true;
        while($phone)
        {
            $phone = TB_PHONE::where('user_id', $request->get('user_id'))
                                ->delete();
        }

        $user = TB_USERS::where('user_id', $request->get('user_id'))
                            ->delete();

        return response()->json(["status","success"],200);
    }

    public function countUserOnline(Request $request){
        $type_user = $request->get('type_user');
        $users = $this->users->countUserOnline($type_user);
        return response()->json(compact('users'),200);
    }

    public  function getLogList(){
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

        return response()->json(compact('data'),200);
    }

    public function getFolderLogs(){
        $folder_log = $this->company->getCompanyFolderLog();
        return response()->json(compact('folder_log'),200);
    }

    public  function getFileLogByFolder(Request $request){
        $folder_log = $request->get('folder_log');
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

    public  function downloadFileLog(Request $request){
        $folder = $request->get('folder');
        $file = $request->get('file');
        return $this->log_viewer->download($folder,$file);
    }
}
