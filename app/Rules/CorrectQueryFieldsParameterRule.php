<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CorrectQueryFieldsParameterRule implements Rule
{
    protected string $requiredFields;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $requiredFields)
    {
        $this->requiredFields = $requiredFields;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $request = app(Request::class);
        $query = $request->all();

        Arr::set($query, $attribute, $value . ',' . $this->requiredFields);
        $request->query->add($query);

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
