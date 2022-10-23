<?php

namespace Database\Factories;

use App\Models\City;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name;

        return [
            'name'                => $name,
            'description'         => fake()->paragraph,
            'slug'                => SlugService::createSlug(City::class, 'slug', $name),
            'active'              => true,
        ];
    }
}
