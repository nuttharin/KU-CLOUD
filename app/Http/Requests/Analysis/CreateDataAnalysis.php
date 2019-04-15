<?php

namespace App\Http\Requests\Analysis;

use App\Http\Requests\FormRequest;

class CreateDataAnalysis extends FormRequest
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
            "service_id" => "required",
            "tableDW_name" => "required",
            "type" => "required",
            "name" => "required",
            "pathArray" => "required",
            "period" => "required",
        ];
    }
}
