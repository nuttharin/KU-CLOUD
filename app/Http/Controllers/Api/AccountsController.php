<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Accounts\AccountsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

use Auth;

class AccountsController extends Controller
{
    /**
     * @var AccountsRepository
     */
    private $account;

    public  function __construct(AccountsRepository $account)
    {
//        if(!Gate::allows('isAdmin')){
//            abort('403',"Sorry, You can do this actions");
//        }
        $this->account = $account;
    }

    public function getAccount(Request $request){
        $data = $this->account->getAccount(Auth::user()->user_id);
        return response()->json(compact('data'),200);
    }

    public function changePrimaryEmail(Request $request){
        $this->account->changePrimaryEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function addEmail(Request $request){
        $this->account->addEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function deleteEmail(Request $request){
        $this->account->deleteEmail(Auth::user()->user_id,$request->get('email'));
    }

    public function changePrimaryPhone(Request $request){
        $this->account->changePrimaryPhone(Auth::user()->user_id,$request->get('phone'));
    }

    public function addPhone(Request $request){
        $this->account->addPhone(Auth::user()->user_id,$request->get('phone'));
    }

    public function deletePhone(Request $request){
        $this->account->deletePhone(Auth::user()->user_id,$request->get('phone'));
    }
}
