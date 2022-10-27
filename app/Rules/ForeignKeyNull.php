<?php

namespace App\Rules;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Database\Eloquent\Model;

class ForeignKeyNull implements InvokableRule
{
    private string $model;
    private string $foreignKey;

    /**
     * @param string $model
     * @param string $foreignKey
     */
    public function __construct(string $model, string $foreignKey)
    {
        $this->model = $model;
        $this->foreignKey = $foreignKey;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     * @throws BindingResolutionException
     */
    public function __invoke($attribute, $value, $fail): void
    {
        $explodedModelName = explode('\\',$this->model);

        $nameModel = $explodedModelName[array_key_last($explodedModelName)];

        $test = app()->make($this->model)::findOrFail($value)->{$this->foreignKey};

        if (!is_null($test)) {
            $fail("The $nameModel (id=$value) $this->foreignKey field must be null");
        }
    }
}
