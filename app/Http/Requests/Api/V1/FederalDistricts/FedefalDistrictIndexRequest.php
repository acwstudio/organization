<?php

namespace App\Http\Requests\Api\V1\FederalDistricts;

use App\Rules\CorrectQueryFieldsParameterRule;
use Illuminate\Foundation\Http\FormRequest;

class FedefalDistrictIndexRequest extends FormRequest
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
     * This ensures that the required query parameters are in place.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fields'        => ['sometimes','required'],
            'fields.federal_districts' => ['sometimes','required', new CorrectQueryFieldsParameterRule('id')]
        ];
    }
}
