<?php

namespace Database\Factories;

use App\Models\Region;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
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
            'federal_district_id' => 1,
            'name'                => $name,
            'description'         => fake()->paragraph,
            'slug'                => SlugService::createSlug(Region::class, 'slug', $name),
            'active'              => true,
        ];
    }
}
