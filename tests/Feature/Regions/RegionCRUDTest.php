<?php

namespace Tests\Feature\Regions;

use App\Models\City;
use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_regions_without_parameters()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        $regions = Region::factory()->count(1)->create([
            'federal_district_id' => $federalDistrict[0]->id
        ]);

        $this->getJson('/api/v1/regions', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict[0]->id,
                            'name' => $regions[0]->name,
                            'description' => $regions[0]->description,
                            'slug' => $regions[0]->slug,
                            'active' => $regions[0]->active,
                            'created_at' => $regions[0]->created_at->toJSON(),
                            'updated_at' => $regions[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[0]->id]),
                                    'related' => route('region.cities', ['id' => $regions[0]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[0]->id])
                                ]
                            ]
                        ]
                    ],
                ]
            ]);
    }

    public function test_index_regions_with_sort_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        $regions = Region::factory()->count(2)->create([
            'federal_district_id' => $federalDistricts[0]->id
        ]);

        $this->getJson('/api/v1/regions?sort=-id', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name' => $regions[1]->name,
                            'description' => $regions[1]->description,
                            'slug' => $regions[1]->slug,
                            'active' => $regions[1]->active,
                            'created_at' => $regions[1]->created_at->toJSON(),
                            'updated_at' => $regions[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[1]->id]),
                                    'related' => route('region.cities', ['id' => $regions[1]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[1]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[1]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name' => $regions[0]->name,
                            'description' => $regions[0]->description,
                            'slug' => $regions[0]->slug,
                            'active' => $regions[0]->active,
                            'created_at' => $regions[0]->created_at->toJSON(),
                            'updated_at' => $regions[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[0]->id]),
                                    'related' => route('region.cities', ['id' => $regions[0]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_regions_with_filter_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistricts[0]->id
        ]);

        $this->getJson('/api/v1/regions?filter[name]=' . $regions[1]->name, [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name' => $regions[1]->name,
                            'description' => $regions[1]->description,
                            'slug' => $regions[1]->slug,
                            'active' => $regions[1]->active,
                            'created_at' => $regions[1]->created_at->toJSON(),
                            'updated_at' => $regions[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[1]->id]),
                                    'related' => route('region.cities', ['id' => $regions[1]->id])
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[1]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[1]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_regions_with_include_parameter(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        Region::factory()->count(2)->create([
            'federal_district_id' => $federalDistricts[0]->id
        ]);

        $regions = Region::all();

        foreach ($regions as $region) {
            City::factory()->count(2)->create([
                'region_id' => $region->id
            ]);
        }

        $cities = City::all();

        $this->getJson('/api/v1/regions?include=cities,federalDistrict', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name' => $regions[0]->name,
                            'description' => $regions[0]->description,
                            'slug' => $regions[0]->slug,
                            'active' => $regions[0]->active,
                            'created_at' => $regions[0]->created_at->toJSON(),
                            'updated_at' => $regions[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[0]->id]),
                                    'related' => route('region.cities', ['id' => $regions[0]->id])
                                ],
                                'data' => [
                                    [
                                        'id' => $cities[0]->id,
                                        'type' => City::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $cities[1]->id,
                                        'type' => City::TYPE_RESOURCE
                                    ]
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[0]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[0]->id])
                                ],
                                'data' => [
                                    'id' => $federalDistricts[0]->id,
                                    'type' => FederalDistrict::TYPE_RESOURCE
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistricts[0]->id,
                            'name' => $regions[1]->name,
                            'description' => $regions[1]->description,
                            'slug' => $regions[1]->slug,
                            'active' => $regions[1]->active,
                            'created_at' => $regions[1]->created_at->toJSON(),
                            'updated_at' => $regions[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'cities' => [
                                'links' => [
                                    'self' => route('region.relationships.cities', ['id' => $regions[1]->id]),
                                    'related' => route('region.cities', ['id' => $regions[1]->id])
                                ],
                                'data' => [
                                    [
                                        'id' => $cities[2]->id,
                                        'type' => City::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $cities[3]->id,
                                        'type' => City::TYPE_RESOURCE
                                    ]
                                ]
                            ],
                            'federalDistrict' => [
                                'links' => [
                                    'self' => route('regions.relationships.federal-district', ['id' => $regions[1]->id]),
                                    'related' => route('regions.federal-district', ['id' => $regions[1]->id])
                                ],
                                'data' => [
                                    'id' => $federalDistricts[0]->id,
                                    'type' => FederalDistrict::TYPE_RESOURCE
                                ]
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'id' => $cities[0]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[0]->id,
                            'name' => $cities[0]->name,
                            'description' => $cities[0]->description,
                            'slug' => $cities[0]->slug,
                            'active' => $cities[0]->active,
                            'created_at' => $cities[0]->created_at->toJSON(),
                            'updated_at' => $cities[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[0]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[0]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[0]->id]),
                                    'related' => route('cities.region', ['id' => $cities[0]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $cities[1]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[0]->id,
                            'name' => $cities[1]->name,
                            'description' => $cities[1]->description,
                            'slug' => $cities[1]->slug,
                            'active' => $cities[1]->active,
                            'created_at' => $cities[1]->created_at->toJSON(),
                            'updated_at' => $cities[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[1]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[1]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[1]->id]),
                                    'related' => route('cities.region', ['id' => $cities[1]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name' => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug' => $federalDistricts[0]->slug,
                            'active' => $federalDistricts[0]->active,
                            'created_at' => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at' => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self' => route('federal-district.relationships.regions', ['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions', ['id' => $federalDistricts[0]->id])
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => $cities[2]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[1]->id,
                            'name' => $cities[2]->name,
                            'description' => $cities[2]->description,
                            'slug' => $cities[2]->slug,
                            'active' => $cities[2]->active,
                            'created_at' => $cities[2]->created_at->toJSON(),
                            'updated_at' => $cities[2]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[2]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[2]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[2]->id]),
                                    'related' => route('cities.region', ['id' => $cities[2]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $cities[3]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[1]->id,
                            'name' => $cities[3]->name,
                            'description' => $cities[3]->description,
                            'slug' => $cities[3]->slug,
                            'active' => $cities[3]->active,
                            'created_at' => $cities[3]->created_at->toJSON(),
                            'updated_at' => $cities[3]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[3]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[3]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[3]->id]),
                                    'related' => route('cities.region', ['id' => $cities[3]->id])
                                ],
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_show_region_without_parameters(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        /** @var Region $region */
        $region = Region::factory()->create([
            'federal_district_id' => $federalDistrict->id
        ]);

        $cities = City::factory()->count(2)->create([
            'region_id' => $region->id
        ]);

        $this->getJson('/api/v1/regions/' . $region->id, [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $region->id,
                    'type' => Region::TYPE_RESOURCE,
                    'attributes' => [
                        'federal_district_id' => $federalDistrict->id,
                        'name' => $region->name,
                        'description' => $region->description,
                        'slug' => $region->slug,
                        'active' => $region->active,
                        'created_at' => $region->created_at->toJSON(),
                        'updated_at' => $region->created_at->toJSON()
                    ],
                    'relationships' => [
                        'cities' => [
                            'links' => [
                                'self' => route('region.relationships.cities', ['id' => $region->id]),
                                'related' => route('region.cities', ['id' => $region->id])
                            ]
                        ],
                        'federalDistrict' => [
                            'links' => [
                                'self' => route('regions.relationships.federal-district', ['id' => $region->id]),
                                'related' => route('regions.federal-district', ['id' => $region->id])
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_show_region_with_include_parameters(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(1)->create();

        /** @var Region $regions */
        $regions = Region::factory()->count(2)->create([
            'federal_district_id' => $federalDistricts[0]->id
        ]);

        foreach ($regions as $region) {
            City::factory()->count(2)->create([
                'region_id' => $region->id
            ]);
        }

        $cities = City::all();

        $this->getJson('/api/v1/regions/' . $regions[1]->id . '?include=cities,federalDistrict', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $regions[1]->id,
                    'type' => Region::TYPE_RESOURCE,
                    'attributes' => [
                        'federal_district_id' => $federalDistricts[0]->id,
                        'name' => $regions[1]->name,
                        'description' => $regions[1]->description,
                        'slug' => $regions[1]->slug,
                        'active' => $regions[1]->active,
                        'created_at' => $regions[1]->created_at->toJSON(),
                        'updated_at' => $regions[1]->created_at->toJSON()
                    ],
                    'relationships' => [
                        'cities' => [
                            'links' => [
                                'self' => route('region.relationships.cities', ['id' => $regions[1]->id]),
                                'related' => route('region.cities', ['id' => $regions[1]->id])
                            ],
                            'data' => [
                                [
                                    'id' => $cities[2]->id,
                                    'type' => City::TYPE_RESOURCE
                                ],
                                [
                                    'id' => $cities[3]->id,
                                    'type' => City::TYPE_RESOURCE
                                ]
                            ]
                        ],
                        'federalDistrict' => [
                            'links' => [
                                'self' => route('regions.relationships.federal-district', ['id' => $regions[1]->id]),
                                'related' => route('regions.federal-district', ['id' => $regions[1]->id])
                            ],
                            'data' => [
                                'id' => $federalDistricts[0]->id,
                                'type' => FederalDistrict::TYPE_RESOURCE
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'id' => $cities[2]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[1]->id,
                            'name' => $cities[2]->name,
                            'description' => $cities[2]->description,
                            'slug' => $cities[2]->slug,
                            'active' => $cities[2]->active,
                            'created_at' => $cities[2]->created_at->toJSON(),
                            'updated_at' => $cities[2]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[2]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[2]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[2]->id]),
                                    'related' => route('cities.region', ['id' => $cities[2]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $cities[3]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $regions[1]->id,
                            'name' => $cities[3]->name,
                            'description' => $cities[3]->description,
                            'slug' => $cities[3]->slug,
                            'active' => $cities[3]->active,
                            'created_at' => $cities[3]->created_at->toJSON(),
                            'updated_at' => $cities[3]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'organizations' => [
                                'links' => [
                                    'self' => route('city.relationships.organizations', ['id' => $cities[3]->id]),
                                    'related' => route('city.organizations', ['id' => $cities[3]->id])
                                ],
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[3]->id]),
                                    'related' => route('cities.region', ['id' => $cities[3]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $federalDistricts[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name' => $federalDistricts[0]->name,
                            'description' => $federalDistricts[0]->description,
                            'slug' => $federalDistricts[0]->slug,
                            'active' => $federalDistricts[0]->active,
                            'created_at' => $federalDistricts[0]->created_at->toJSON(),
                            'updated_at' => $federalDistricts[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'regions' => [
                                'links' => [
                                    'self' => route('federal-district.relationships.regions', ['id' => $federalDistricts[0]->id]),
                                    'related' => route('federal-district.regions', ['id' => $federalDistricts[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_store_region_without_relationships(): void
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistrict = FederalDistrict::factory()->create();

        $this->postJson('/api/v1/regions', [
            'data' => [
                'type' => 'regions',
                'attributes' => [
                    'federal_district_id' => $federalDistrict->id,
                    'name' => 'test region',
                    'description' => 'test region description',
                    'active' => true,
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => Region::firstOrFail()->id,
                    'type' => 'regions',
                    'attributes' => [
                        'federal_district_id' => $federalDistrict->id,
                        'name' => 'test region',
                        'description' => 'test region description',
                        'slug' => 'test-region',
                        'active' => true,
                        'created_at' => now()->setMilliseconds(0)->toJSON(),
                        'updated_at' => now()->setMicroseconds(0)->toJSON(),
                    ]
                ]
            ]);
    }

    public function test_store_region_with_federal_district_relationships()
    {
        $federalDistrict = FederalDistrict::factory()->create();

        $this->postJson('/api/v1/regions', [
            'data' => [
                'type' => 'regions',
                'attributes' => [
                    'federal_district_id' => $federalDistrict->id,
                    'name' => 'test region',
                    'description' => 'test region description',
                    'active' => true,
                ],
                'relationships' => [
                    'federalDistrict' => [
                        'data' => [
                            'id' => $federalDistrict->id,
                            'type' => FederalDistrict::TYPE_RESOURCE
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
                    'id' => Region::firstOrFail()->id,
                    'type' => 'regions',
                    'attributes' => [
                        'name' => 'test region',
                        'description' => 'test region description',
                        'slug' => 'test-region',
                        'active' => true,
                        'created_at' => now()->setMilliseconds(0)->toJSON(),
                        'updated_at' => now()->setMicroseconds(0)->toJSON(),
                    ],
                    'relationships' => [
                        'federalDistrict' => [
                            'links' => [
                                'self' => route('regions.relationships.federal-district', ['id' => Region::firstOrFail()->id]),
                                'related' => route('regions.federal-district', ['id' => Region::firstOrFail()->id])
                            ]
                        ],
                        'cities' => [
                            'links' => [
                                'self' => route('region.relationships.cities', ['id' => Region::firstOrFail()->id]),
                                'related' => route('region.cities', ['id' => Region::firstOrFail()->id])
                            ]
                        ]
                    ]
                ]
            ]);

        $this->getJson(route('regions.relationships.federal-district', ['id' => Region::firstOrFail()->id]),[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $federalDistrict->id,
                'type' => FederalDistrict::TYPE_RESOURCE
            ]
        ]);
    }

    public function test_store_region_with_cities_relationships()
    {
        $federalDistrict = FederalDistrict::factory()->create();

        City::factory()->count(3)->create([
            'region_id' => null
        ]);

        $cities = City::all();

        $this->postJson('/api/v1/regions', [
            'data' => [
                'type' => 'regions',
                'attributes' => [
                    'federal_district_id' => $federalDistrict->id,
                    'name' => 'test region',
                    'description' => 'test region description',
                    'active' => true,
                ],
                'relationships' => [
                    'cities' => [
                        'data' => [
                            [
                                'id' => $cities[0]->id,
                                'type' => City::TYPE_RESOURCE
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
                    'id' => Region::firstOrFail()->id,
                    'type' => 'regions',
                    'attributes' => [
                        'name' => 'test region',
                        'description' => 'test region description',
                        'slug' => 'test-region',
                        'active' => true,
                        'created_at' => now()->setMilliseconds(0)->toJSON(),
                        'updated_at' => now()->setMicroseconds(0)->toJSON(),
                    ],
                    'relationships' => [
                        'federalDistrict' => [
                            'links' => [
                                'self' => route('regions.relationships.federal-district', ['id' => Region::firstOrFail()->id]),
                                'related' => route('regions.federal-district', ['id' => Region::firstOrFail()->id])
                            ]
                        ],
                        'cities' => [
                            'links' => [
                                'self' => route('region.relationships.cities', ['id' => Region::firstOrFail()->id]),
                                'related' => route('region.cities', ['id' => Region::firstOrFail()->id])
                            ]
                        ]
                    ]
                ]
            ]);
        City::firstOrFail()->update([
            'region_id' => Region::firstOrFail()->id
        ]);

        $this->getJson(route('region.relationships.cities', ['id' => Region::firstOrFail()->id]),[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
        ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $cities[0]->id,
                        'type' => City::TYPE_RESOURCE
                    ]
                ]
            ]);
    }
}
