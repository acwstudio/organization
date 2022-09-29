<?php

namespace Database\Factories;

use App\Models\FederalDistrict;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FederalDistrict>
 */
class FederalDistrictFactory extends Factory
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
            'name'        => $name,
            'description' => fake()->paragraph,
            'slug'        => SlugService::createSlug(FederalDistrict::class, 'slug', $name),
            'active'      => true,
//            'created_at'  => now()
        ];
    }
}
