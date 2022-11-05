<?php

namespace Tests\Feature\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FederalDistrictCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_federal_districts_without_parameters(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        $this->getJson('/api/v1/federal-districts', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [
                            'name'        => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug'        => $federalDistricts[0]->slug,
                            'active'      => $federalDistricts[0]->active,
                            'created_at'  => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at'  => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self'    => route('federal-district.relationships.regions',['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[0]->id])
                                ]
                            ]
                        ]
                    ],
                ]
            ]);
    }

    public function test_index_federal_districts_with_sort_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(2)->create();

        $this->getJson('/api/v1/federal-districts?sort=-id', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistricts[1]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [
                            'name'        => $federalDistricts[1]->name,
                            'description' => $federalDistricts[1]->description,
                            'slug'        => $federalDistricts[1]->slug,
                            'active'      => $federalDistricts[1]->active,
                            'created_at'  => $federalDistricts[1]->created_at->toJSON(),
                            'updated_at'  => $federalDistricts[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self'    => route('federal-district.relationships.regions',['id' => $federalDistricts[1]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[1]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id'   => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [
                            'name'        => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug'        => $federalDistricts[0]->slug,
                            'active'      => $federalDistricts[0]->active,
                            'created_at'  => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at'  => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self'    => route('federal-district.relationships.regions',['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_federal_districts_with_filter_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(2)->create();

        $this->getJson('/api/v1/federal-districts?filter[name]=' . $federalDistricts[0]->name, [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [
                            'name'        => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug'        => $federalDistricts[0]->slug,
                            'active'      => $federalDistricts[0]->active,
                            'created_at'  => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at'  => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self'    => route('federal-district.relationships.regions',['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_federal_districts_with_include_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        $regions = Region::factory()->count(2)->create([
            'federal_district_id' => $federalDistricts[0]->id
        ]);

        $this->getJson('/api/v1/federal-districts?include=regions', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes'      => [
                            'name'        => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug'        => $federalDistricts[0]->slug,
                            'active'      => $federalDistricts[0]->active,
                            'created_at'  => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at'  => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self'    => route('federal-district.relationships.regions',['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions',['id' => $federalDistricts[0]->id])
                                ],
                                'data' => [
                                    [
                                        'id'   => $regions[0]->id,
                                        'type' => Region::TYPE_RESOURCE
                                    ],
                                    [
                                        'id'   => $regions[1]->id,
                                        'type' => Region::TYPE_RESOURCE
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'description'         => $regions[0]->description,
                            'slug'                => $regions[0]->slug,
                            'active'              => $regions[0]->active,
                            'created_at'          => $regions[0]->created_at->toJSON(),
                            'updated_at'          => $regions[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self'    => route('region.relationships.cities',['id' => $regions[0]->id]),
                                    'related' => route('region.cities',['id' => $regions[0]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self'    => route('regions.relationships.federal-district',['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_show_federal_district_without_parameters(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id, [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $federalDistrict->id,
                    'type' => FederalDistrict::TYPE_RESOURCE,
                    'attributes' => [
                        'name'        => $federalDistrict->name,
                        'description' => $federalDistrict->description,
                        'slug'        => $federalDistrict->slug,
                        'active'      => $federalDistrict->active,
                        'created_at'  => $federalDistrict->created_at->toJSON(),
                        'updated_at'  => $federalDistrict->created_at->toJSON()
                    ],
                    'relationships' => [
                        'regions' => [
                            'links' => [
                                'self' => route('federal-district.relationships.regions', ['id' => $federalDistrict->id]),
                                'related' => route('federal-district.regions', ['id' => $federalDistrict->id])
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_show_federal_district_with_include_parameter()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistrict->id,
        ]);

        $regions = Region::all();

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id . '?include=regions', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $federalDistrict->id,
                    'type' => FederalDistrict::TYPE_RESOURCE,
                    'attributes' => [

                    ],
                    'relationships' => [
                        'regions' => [
                            'links' => [
                                'self' => route('federal-district.relationships.regions', ['id' => $federalDistrict->id]),
                                'related' => route('federal-district.regions', ['id' => $federalDistrict->id])
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
                'included' => [
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict->id,
                            'name'                => $regions[0]->name,
                            'description'         => $regions[0]->description,
                            'slug'                => $regions[0]->slug,
                            'active'              => $regions[0]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self'    => route('region.relationships.cities',['id' => $regions[0]->id]),
                                    'related' => route('region.cities',['id' => $regions[0]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self'    => route('regions.relationships.federal-district',['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[0]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict->id,
                            'name'                => $regions[1]->name,
                            'description'         => $regions[1]->description,
                            'slug'                => $regions[1]->slug,
                            'active'              => $regions[1]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self'    => route('region.relationships.cities',['id' => $regions[1]->id]),
                                    'related' => route('region.cities',['id' => $regions[1]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self'    => route('regions.relationships.federal-district',['id' => $regions[1]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[1]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id'   => $regions[2]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict->id,
                            'name'                => $regions[2]->name,
                            'description'         => $regions[2]->description,
                            'slug'                => $regions[2]->slug,
                            'active'              => $regions[2]->active,
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self'    => route('region.relationships.cities',['id' => $regions[2]->id]),
                                    'related' => route('region.cities',['id' => $regions[2]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self'    => route('regions.relationships.federal-district',['id' => $regions[2]->id]),
                                    'related' => route('regions.federal-district',['id' => $regions[2]->id])
                                ]
                            ]
                        ]
                    ]
                ],
            ]);
    }

    public function test_store_federal_district_without_relationships()
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
                    'id' => FederalDistrict::firstOrFail()->id,
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
    }

    public function test_store_federal_district_with_regions_relationships()
    {
        Region::factory()->count(3)->create([
            'federal_district_id' => null
        ]);

        $regions = Region::all();

        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => 'federalDistricts',
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'test description',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [
                            [
                                'id' => $regions[0]->id,
                                'type' => Region::TYPE_RESOURCE
                            ]
                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => FederalDistrict::firstOrFail()->id,
                    'type' => 'federalDistricts',
                    'attributes' => [
                        'name'        => 'Северо-западный федеральный округ',
                        'description' => 'test description',
                        'slug'        => 'severo-zapadnyy-federalnyy-okrug',
                        'active'      => true,
                        'created_at'  => now()->setMilliseconds(0)->toJSON(),
                        'updated_at'  => now() ->setMicroseconds(0)->toJSON(),
                    ],
                    'relationships' => [
                        'regions' => [
                            'links' => [
                                'self' => route('federal-district.relationships.regions', ['id' => FederalDistrict::firstOrFail()->id]),
                                'related' => route('federal-district.regions', ['id' => FederalDistrict::firstOrFail()->id])
                            ]
                        ]
                    ]
                ]
            ]);

        $this->getJson(route('federal-district.relationships.regions', ['id' => FederalDistrict::firstOrFail()->id]),[
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $regions[0]->id,
                    'type' => Region::TYPE_RESOURCE
                ]
            ]
        ]);
    }

    public function test_update_federal_district_without_relationships()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(3)->create()->first();

        $this->patchJson('/api/v1/federal-districts/' . $federalDistrict->id, [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'another name'
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(204);

        $this->assertDatabaseHas('federal_districts', [
            'id'          => $federalDistrict->id,
            'name'        => 'another name',
            'description' => $federalDistrict->description,
            'slug'        => $federalDistrict->slug,
            'active'      => 1,
        ]);
    }

    public function test_update_federal_district_with_regions_relationships()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistricts = FederalDistrict::factory()->count(3)->create();

        foreach ($federalDistricts as $federalDistrict) {
            /** @var Region $regions */
            $regions = Region::factory()->count(3)->create([
                'federal_district_id' => $federalDistrict->id
            ]);

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
                                    'id' => $regions->firstOrFail()->id,
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

    public function test_destroy_federal_district_without_relationships()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistricts = FederalDistrict::factory()->count(3)->create();

        foreach ($federalDistricts as $federalDistrict) {

            $this->delete('/api/v1/federal-districts/' . $federalDistrict->id, [], [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json',
            ])->assertStatus(204);

            $this->assertSoftDeleted('federal_districts', [
                'id' => $federalDistrict->id
            ]);
        }
    }

    public function test_destroy_federal_district_with_relationships()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistricts = FederalDistrict::factory()->count(3)->create();

        foreach ($federalDistricts as $federalDistrict) {
            /** @var Region $regions */
            $regions = Region::factory()->count(3)->create([
                'federal_district_id' => $federalDistrict->id
            ]);

            $this->delete('/api/v1/federal-districts/' . $federalDistrict->id, [], [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json',
            ])->assertStatus(403);

            $this->assertDatabaseHas('regions', [
                'federal_district_id' => $federalDistrict->id,
            ]);
        }
    }
}
