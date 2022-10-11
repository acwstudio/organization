<?php

namespace Tests\Feature\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * 01. Test federal districts index resource collection
 * 02. Test federal districts index resource collection with include parameter
 */
class FederalDistrictsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public function test_federal_districts_index_resource_collection_attributes(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(1)->create();

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
                        ],
                    ],
                ]
            ]);
    }

    public function test_federal_districts_index_resource_collection_relationships(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(1)->create();

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

                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self' => route('federal-district.relationships.regions',['id' => $federalDistrict[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistrict[0]->id])
                                ]
                            ]
                        ]
                    ],
                ]
            ]);
    }

    public function test_federal_districts_index_resource_collection_with_include_parameter()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        foreach ($federalDistricts as $federalDistrict) {
            Region::factory()->count(3)->create([
                'federal_district_id' => $federalDistrict->first()->id,
            ]);
        }

        $regions = Region::all();

        $this->getJson('/api/v1/federal-districts?include=regions', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [

                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self' => route('federal-district.relationships.regions',['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[0]->id])
                                ],
                                'data' => [
                                    [
                                        'id' => $regions[0]->id,
                                        'type' => Region::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $regions[1]->id,
                                        'type' => Region::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $regions[2]->id,
                                        'type' => Region::TYPE_RESOURCE
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                'included' => [
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name'                => $regions[0]->name,
                            'description'         => $regions[0]->description,
                            'slug'                => $regions[0]->slug,
                            'active'              => $regions[0]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities',['id' => $regions[0]->id]),
                                    'related' => route('region.cities',['id' => $regions[0]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district',['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[0]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name'                => $regions[1]->name,
                            'description'         => $regions[1]->description,
                            'slug'                => $regions[1]->slug,
                            'active'              => $regions[1]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities',['id' => $regions[1]->id]),
                                    'related' => route('region.cities',['id' => $regions[1]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district',['id' => $regions[1]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[1]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[2]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name'                => $regions[2]->name,
                            'description'         => $regions[2]->description,
                            'slug'                => $regions[2]->slug,
                            'active'              => $regions[2]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities',['id' => $regions[2]->id]),
                                    'related' => route('region.cities',['id' => $regions[2]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district',['id' => $regions[2]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[2]->id])
                                ]
                            ]
                        ]
                    ]
                ],
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
