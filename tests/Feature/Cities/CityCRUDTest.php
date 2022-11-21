<?php

namespace Tests\Feature\Cities;

use App\Models\City;
use App\Models\Organization;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_cities_without_parameters(): void
    {
        /** @var Region $region */
        $region = Region::factory()->count(1)->create([
            'federal_district_id' => null
        ]);

        /** @var City $cities */
        $cities = City::factory()->count(1)->create([
            'region_id' => $region[0]->id
        ]);

        $this->getJson('/api/v1/cities', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $cities[0]->id,
                        'type' => City::TYPE_RESOURCE,
                        'attributes' => [
                            'region_id' => $region[0]->id,
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
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[0]->id]),
                                    'related' => route('cities.region', ['id' => $cities[0]->id])
                                ]
                            ]
                        ]
                    ],
                ]
            ]);
    }

    public function test_index_regions_with_sort_parameter(): void
    {
        /** @var Region $regions */
        $regions = Region::factory()->count(1)->create([
            'federal_district_id' => null
        ]);

        /** @var City $cities */
        $cities = City::factory()->count(2)->create([
            'region_id' => $regions[0]->id
        ]);

        $this->getJson('/api/v1/cities?sort=-id', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
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
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[1]->id]),
                                    'related' => route('cities.region', ['id' => $cities[1]->id])
                                ]
                            ]
                        ]
                    ],
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
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[0]->id]),
                                    'related' => route('cities.region', ['id' => $cities[0]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_regions_with_filter_parameter(): void
    {
        /** @var Region $regions */
        $regions = Region::factory()->count(1)->create([
            'federal_district_id' => null
        ]);

        /** @var City $cities */
        $cities = City::factory()->count(3)->create([
            'region_id' => $regions[0]->id
        ]);

        $this->getJson('/api/v1/cities?filter[name]=' . $cities[1]->name, [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
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
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[1]->id]),
                                    'related' => route('cities.region', ['id' => $cities[1]->id])
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_index_regions_with_include_parameter(): void
    {
        /** @var Region $regions */
        $regions = Region::factory()->count(1)->create([
            'federal_district_id' => null
        ]);

        /** @var City $cities */
        City::factory()->count(2)->create([
            'region_id' => $regions[0]->id
        ]);

        $cities = City::all();

        foreach ($cities as $city) {
            Organization::factory()->count(2)->create([
                'city_id' => $city->id
            ]);
        }

        $organizations = Organization::all();

        $this->getJson('/api/v1/cities?include=organizations,region', [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
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
                                'data' => [
                                    [
                                        'id' => $organizations[0]->id,
                                        'type' => Organization::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $organizations[1]->id,
                                        'type' => Organization::TYPE_RESOURCE
                                    ]
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[0]->id]),
                                    'related' => route('cities.region', ['id' => $cities[0]->id])
                                ],
                                'data' => [
                                    'id' => $regions[0]->id,
                                    'type' => Region::TYPE_RESOURCE
                                ]
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
                                'data' => [
                                    [
                                        'id' => $organizations[2]->id,
                                        'type' => Organization::TYPE_RESOURCE
                                    ],
                                    [
                                        'id' => $organizations[3]->id,
                                        'type' => Organization::TYPE_RESOURCE
                                    ]
                                ]
                            ],
                            'region' => [
                                'links' => [
                                    'self' => route('cities.relationships.region', ['id' => $cities[1]->id]),
                                    'related' => route('cities.region', ['id' => $cities[1]->id])
                                ],
                                'data' => [
                                    'id' => $regions[0]->id,
                                    'type' => Region::TYPE_RESOURCE
                                ]
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'id' => $organizations[0]->id,
                        'type' => Organization::TYPE_RESOURCE,
                        'attributes' => [
                            'parent_id' => $organizations[0]->parent_id,
                            'city_id' => $cities[0]->id,
                            'organization_type_id' => $organizations[0]->organization_type_id,
                            'name' => $organizations[0]->name,
                            'abbreviation' => $organizations[0]->abbreviation,
                            'description' => $organizations[0]->description,
                            'site' => $organizations[0]->site,
                            'email' => $organizations[0]->email,
                            'phone' => $organizations[0]->phone,
                            'address' => $organizations[0]->address,
                            'slug' => $organizations[0]->slug,
                            'active' => $organizations[0]->active,
                            'created_at' => $organizations[0]->created_at->toJSON(),
                            'updated_at' => $organizations[0]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'faculties' => [
                                'links' => [
                                    'self' => route('organization.relationships.faculties', ['id' => $organizations[0]->id]),
                                    'related' => route('organization.faculties', ['id' => $organizations[0]->id])
                                ],
                            ],
                            'city' => [
                                'links' => [
                                    'self' => route('organizations.relationships.city', ['id' => $organizations[0]->id]),
                                    'related' => route('organizations.city', ['id' => $organizations[0]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $organizations[1]->id,
                        'type' => Organization::TYPE_RESOURCE,
                        'attributes' => [
                            'parent_id' => $organizations[1]->parent_id,
                            'city_id' => $cities[0]->id,
                            'organization_type_id' => $organizations[1]->organization_type_id,
                            'name' => $organizations[1]->name,
                            'abbreviation' => $organizations[1]->abbreviation,
                            'description' => $organizations[1]->description,
                            'site' => $organizations[1]->site,
                            'email' => $organizations[1]->email,
                            'phone' => $organizations[1]->phone,
                            'address' => $organizations[1]->address,
                            'slug' => $organizations[1]->slug,
                            'active' => $organizations[1]->active,
                            'created_at' => $organizations[1]->created_at->toJSON(),
                            'updated_at' => $organizations[1]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'faculties' => [
                                'links' => [
                                    'self' => route('organization.relationships.faculties', ['id' => $organizations[1]->id]),
                                    'related' => route('organization.faculties', ['id' => $organizations[1]->id])
                                ],
                            ],
                            'city' => [
                                'links' => [
                                    'self' => route('organizations.relationships.city', ['id' => $organizations[1]->id]),
                                    'related' => route('organizations.city', ['id' => $organizations[1]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
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
                            ]
                        ]
                    ],
                    [
                        'id' => $organizations[2]->id,
                        'type' => Organization::TYPE_RESOURCE,
                        'attributes' => [
                            'parent_id' => $organizations[2]->parent_id,
                            'city_id' => $cities[1]->id,
                            'organization_type_id' => $organizations[2]->organization_type_id,
                            'name' => $organizations[2]->name,
                            'abbreviation' => $organizations[2]->abbreviation,
                            'description' => $organizations[2]->description,
                            'site' => $organizations[2]->site,
                            'email' => $organizations[2]->email,
                            'phone' => $organizations[2]->phone,
                            'address' => $organizations[2]->address,
                            'slug' => $organizations[2]->slug,
                            'active' => $organizations[2]->active,
                            'created_at' => $organizations[2]->created_at->toJSON(),
                            'updated_at' => $organizations[2]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'city' => [
                                'links' => [
                                    'self' => route('organizations.relationships.city', ['id' => $organizations[2]->id]),
                                    'related' => route('organizations.city', ['id' => $organizations[2]->id])
                                ],
                            ],
                            'faculties' => [
                                'links' => [
                                    'self' => route('organization.relationships.faculties', ['id' => $organizations[2]->id]),
                                    'related' => route('organization.faculties', ['id' => $organizations[2]->id])
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => $organizations[3]->id,
                        'type' => Organization::TYPE_RESOURCE,
                        'attributes' => [
                            'parent_id' => $organizations[3]->parent_id,
                            'city_id' => $cities[1]->id,
                            'organization_type_id' => $organizations[3]->organization_type_id,
                            'name' => $organizations[3]->name,
                            'abbreviation' => $organizations[3]->abbreviation,
                            'description' => $organizations[3]->description,
                            'site' => $organizations[3]->site,
                            'email' => $organizations[3]->email,
                            'phone' => $organizations[3]->phone,
                            'address' => $organizations[3]->address,
                            'slug' => $organizations[3]->slug,
                            'active' => $organizations[3]->active,
                            'created_at' => $organizations[3]->created_at->toJSON(),
                            'updated_at' => $organizations[3]->created_at->toJSON()
                        ],
                        'relationships' => [
                            'city' => [
                                'links' => [
                                    'self' => route('organizations.relationships.city', ['id' => $organizations[3]->id]),
                                    'related' => route('organizations.city', ['id' => $organizations[3]->id])
                                ],
                            ],
                            'faculties' => [
                                'links' => [
                                    'self' => route('organization.relationships.faculties', ['id' => $organizations[3]->id]),
                                    'related' => route('organization.faculties', ['id' => $organizations[3]->id])
                                ],
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
