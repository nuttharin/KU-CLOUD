<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\FormRequest;

class Register extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:TB_USERS,username|max:10',
            'fname' => 'required|max:50',
            'lname' => 'required|max:50',
            'password' => 'required|max:20',
            'email' => 'required|unique:TB_EMAIL,email_user',
            'phone' => 'required|unique:TB_PHONE,phone_user',
        ];
    }
}
