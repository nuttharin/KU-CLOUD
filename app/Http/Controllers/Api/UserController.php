<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LogViewer\LogViewer;
use App\Repositories\TB_USERS\UsersRepository;
use App\TB_USERS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $users;
    private $companies;
    private $auth;
    private $webservices;
    private $static;
    private $log_viewer;

    public function __construct(UsersRepository $users, Request $request)
    {

        // if (!Gate::allows('isCustomer)) {
        //     abort('403', "Sorry, You can do this actions");
        // }

        $this->users = $users;
        $this->log_viewer = new LogViewer();

        $this->middleware('jwt.verify');
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::user();
            $company_id = $this->auth->user_company()->first()->company_id;
            $this->log_viewer->setFolder('COMPANY_' . $company_id);
            return $next($request);
        });

    }

    public function getAllUser(Request $request)
    {
        $columns = array(
            0 => 'fname',
            1 => 'phone_user',
            2 => 'email_user',
            3 => 'block',
            4 => 'sub_type_user',
            5 => 'online',
        );
        $companyID = $this->auth->user_company()->first()->company_id;
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $total_user = $this->users->countUser('COMPANY', $companyID)[0]->count;

        if (empty($search)) {
            $data = $this->users->getByTypeForCompany('COMPANY', $companyID, $start, $length, $order, $dir);

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
            $data = $this->users->searchByTypeForCompany('COMPANY', $companyID, $start, $length, $search, $order, $dir);
            if (!empty($data)) {
                $this->log_viewer->logRequest($request);
                $test = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_user,
                    'recordsFiltered' => count($data),
                    'data' => $data,
                );

                return response()->json($test, 200)->header('Content-Type', 'application/json');
            }
        }
        return response()->json([
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
        ], 200);
    }

    public function addUserCompany(Request $request)
    {
        $data = [
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            // 'password' => $request->get('password'),
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
        $columns = array(
            0 => 'fname',
            1 => 'phone_user',
            2 => 'email_user',
            3 => 'block',
            4 => 'online',
        );
        $companyID = $this->auth->user_company()->first()->company_id;
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $total_user = $this->users->countUser('CUSTOMER', $companyID)[0]->count;

        if (empty($search)) {
            $data = $this->users->getByTypeForCompany('CUSTOMER', $companyID, $start, $length, $order, $dir);
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
            $data = $this->users->searchByTypeForCompany('CUSTOMER', $companyID, $start, $length, $search, $order, $dir);
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
            'username' => $request->get('username'),
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
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
}
