<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\FormRequest;

class UsersRequest extends FormRequest
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
            'fname'=>'required|max:50',
            'lname'=>'required|max:50',
            'password'=>'required|max:50',
            'sub_type_user'=>'required',
            'email'=>'required|unique:TB_EMAIL,email_user',
            'phone'=>'required|unique:TB_PHONE,phone_user',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fname.required' => 'The firstname field is required.',
            'lname.required' => 'The lastname field is required.',
        ];
    }
}
