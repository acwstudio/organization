<?php

namespace App\Http\Requests\Api\V1\FederalDistricts;

use Illuminate\Foundation\Http\FormRequest;

class FederalDistrictRegionsUpdateRelationshipsRequest extends FormRequest
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
            'data'        => 'present|array',
            'data.*.id'   => 'required|integer|exists:regions,id',
            'data.*.type' => 'required|string|in:regions',
        ];
    }
}
