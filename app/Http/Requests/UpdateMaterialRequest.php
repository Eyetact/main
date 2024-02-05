<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
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
            'material_name' => 'required|string|min:10|max:text',
			'material_id' => 'required|string|min:5|max:text',
			'materials_eu_category' => 'nullable',
			'material_unit' => 'required|in:I.U.,mg,mcg',
        ];
    }
}
