<?php

namespace App\Http\Requests\Api\V1\Cities;

use App\Rules\CorrectQueryFieldsParameterRule;
use Illuminate\Foundation\Http\FormRequest;

class CityIndexRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fields'        => ['sometimes','required'],
            'fields.cities' => ['sometimes','required', new CorrectQueryFieldsParameterRule('region_id,id')]
        ];
    }
}
