<?php

namespace App\Http\Requests\Api\V1\FederalDistricts;

use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'data'        => ['present','array'],
            'data.*'      => ['required','array','size:2'],
            'data.*.id'   => ['sometimes','required','integer','distinct','exists:regions,id'],
            'data.*.type' => ['sometimes','required','string','in:' . Region::TYPE_RESOURCE],
        ];
    }
}
