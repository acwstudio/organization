<?php

namespace Tests\Feature\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FederalDistrictsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_federal_districts_resource_collection(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(3)->create();

        $this->getJson('/api/v1/federal-districts', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $federalDistrict[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name' => $federalDistrict[0]->name,
                            'description' => $federalDistrict[0]->description,
                            'slug' => $federalDistrict[0]->slug,
                            'active' => $federalDistrict[0]->active,
                            'created_at' => $federalDistrict[0]->created_at->toJSON()
                        ]
                    ],
                    [
                        'id' => $federalDistrict[1]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name' => $federalDistrict[1]->name,
                            'description' => $federalDistrict[1]->description,
                            'slug' => $federalDistrict[1]->slug,
                            'active' => $federalDistrict[1]->active,
                            'created_at' => $federalDistrict[1]->created_at->toJSON()
                        ]
                    ],
                    [
                        'id' => $federalDistrict[2]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name' => $federalDistrict[2]->name,
                            'description' => $federalDistrict[2]->description,
                            'slug' => $federalDistrict[2]->slug,
                            'active' => $federalDistrict[2]->active,
                            'created_at' => $federalDistrict[2]->created_at->toJSON()
                        ]
                    ]
                ]
            ]);
    }

    public function test_get_federal_districts_resource()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id, [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'         => $federalDistrict->id,
                    'type'       => FederalDistrict::TYPE_RESOURCE,
                    'attributes' => [
                        'name'        => $federalDistrict->name,
                        'description' => $federalDistrict->description,
                        'slug'        => $federalDistrict->slug,
                        'active'      => $federalDistrict->active,
                        'created_at'  => $federalDistrict->created_at->toJSON()
                    ]
                ]
            ]);
    }

    public function test_post_federal_districts_resource()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => 'federalDistricts',
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'test description',
                    'active'      => true,
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'type' => 'federalDistricts',
                    'attributes' => [
                        'name'        => 'Северо-западный федеральный округ',
                        'description' => 'test description',
                        'slug'        => 'severo-zapadnyy-federalnyy-okrug',
                        'active'      => true,
                        'created_at'  => now()->setMilliseconds(0)->toJSON(),
                        'updated_at'  => now() ->setMicroseconds(0)->toJSON(),
                    ]
                ]
            ]);

        $this->assertDatabaseHas('federal_districts', [
            'id'          => 1,
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'test description',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true,
        ]);
    }

    public function test_patch_federal_districts_resource()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(3)->create()->first();

        $this->patchJson('/api/v1/federal-districts/1', [
            'data' => [
                'type' => 'federalDistricts',
                'attributes' => [
                    'name'        => $federalDistrict->name,
                    'description' => $federalDistrict->description,
                    'active'      => $federalDistrict->active,
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(204);

        $this->assertDatabaseHas('federal_districts', [
            'id'          => 1,
            'name'        => $federalDistrict->name,
            'description' => $federalDistrict->description,
            'slug'        => $federalDistrict->slug,
            'active'      => 1,
        ]);
    }

    public function test_patch_federal_districts_resource_with_related_regions()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistricts = FederalDistrict::factory()->count(3)->create();

        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => 1
        ]);

        foreach ($federalDistricts as $key => $federalDistrict) {

            $this->patchJson('/api/v1/federal-districts/' . $federalDistrict->id, [
                'data' => [
                    'type' => 'federalDistricts',
                    'attributes' => [
                        'active'      => false,
                    ],
                    'relationships' => [
                        'regions' => [
                            'data' => [
                                [
                                    'id' => 1,
                                    'type' => 'regions'
                                ]
                            ],
                        ]
                    ]
                ]
            ], [
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json',
            ])
                ->assertStatus(204);

            $this->assertDatabaseHas('federal_districts', [
                'id'          => $federalDistrict->id,
                'name'        => $federalDistrict->name,
                'description' => $federalDistrict->description,
                'slug'        => $federalDistrict->slug,
                'active'      => 0,
            ]);

            $this->assertDatabaseHas('regions', [
                'federal_district_id' => $federalDistrict->id,
            ]);
        }
    }
}
