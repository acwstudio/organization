<?php

namespace App\Rules;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Database\Eloquent\Model;

class ForeignKeyNullRule implements InvokableRule
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

        $exist = app()->make($this->model)::where('id', $value)->first();

        if ($exist) {
            if (!is_null($exist->{$this->foreignKey})) {
                $fail("The $nameModel (id=$value) $this->foreignKey field must be null");
            }
        }
    }
}
