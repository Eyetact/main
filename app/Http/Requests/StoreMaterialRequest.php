<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
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
            'material_name' => 'required|string',
			'material_id' => 'required|string',
			'materials_eu_category' => 'nullable',
			'material_unit' => 'required|in:I.U.,mg,mcg',
        ];
    }
}
