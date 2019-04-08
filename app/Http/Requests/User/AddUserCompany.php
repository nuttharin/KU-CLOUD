<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class AddUserCompany extends FormRequest
{
    protected $rules = [
        'username' => 'required|unique:TB_USERS,username|max:10',
        'fname' => 'required|max:50',
        'lname' => 'required|max:50',
        'sub_type_user' => 'required',
        'email' => 'required|unique:TB_EMAIL,email_user',
        'phone' => 'required|unique:TB_PHONE,phone_user',
    ];

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
        return $this->rules;
    }
}
