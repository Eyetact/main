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
        $menuId = $this->route('menu');
        // dd($menuId);
        return [
            // 'name' =>  [
            //     'required',
            //     Rule::unique('modules', 'name')->ignore($menuId),
            // ],
            'name' => 'required | unique:menus,name,' . $menuId,
            'code' => 'required | unique:menus,code,' . $menuId,
            'path' => 'required | unique:menus,path,' . $menuId ,
            'created_date' => 'required',
        ];
    }
}
