<?php

namespace Database\Factories;

use App\Models\Organization;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name;
        $abbreviation = preg_replace('/\b(\w)\w*\W*/', '\1', $name);
//        dd($abbreviation);
        return [
            'id'                  => fake()->uuid,
            'name'                => $name,
            'abbreviation'        => $abbreviation,
            'description'         => fake()->paragraph,
            'site'                => fake()->url,
            'email'               => fake()->email,
            'phone'               => fake()->phoneNumber,
            'address'             => fake()->address,
            'slug'                => SlugService::createSlug(Organization::class, 'slug', $name),
            'plaque_image'        => fake()->imageUrl,
            'preview_image'       => fake()->imageUrl,
            'base_image'          => fake()->imageUrl,
//            'active'              => true,
        ];
    }
}
