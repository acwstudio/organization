<?php

namespace App\Http\Requests\Api\V1\Cities;

use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class CitiesRegionUpdateRelationshipsRequest extends FormRequest
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
            'data'      => ['required', 'array'],
            'data.id'   => ['required','integer','exists:regions,id'],
            'data.type' => ['required','string','in:' . Region::TYPE_RESOURCE],
        ];
    }
}
