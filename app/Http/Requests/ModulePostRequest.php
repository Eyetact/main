<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ModulePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $moduleId = $this->route('module');
        return [
            'name' =>  [
                'required',
                Rule::unique('modules', 'name')->ignore($moduleId),
            ],
            'code' => 'required | unique:menus,code',
            'path' => 'required | unique:menus,path',
            'created_date' => 'required',
            'assigned_attributes' => 'required'
        ];
    }
}
