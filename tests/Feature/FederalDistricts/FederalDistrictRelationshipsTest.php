<?php

namespace Tests\Feature\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FederalDistrictRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_federal_districts_regions_index_relationships()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistrict->id
        ]);

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id . '/relationships/regions', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                    ],
                    [
                        'id'   => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                    ],
                    [
                        'id'   => $regions[2]->id,
                        'type' => Region::TYPE_RESOURCE,
                    ],
                ]
            ]);
    }

    public function test_federal_districts_regions_index_related()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistrict->id
        ]);

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id . '/regions', [
            'accept'       => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $regions[0]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict->id,
                            'name'                => $regions[0]->name,
                            'description'         => $regions[0]->description,
                            'slug'                => $regions[0]->slug,
                            'active'              => $regions[0]->active,
                        ]
                    ],
                    [
                        'id'   => $regions[1]->id,
                        'type' => Region::TYPE_RESOURCE,
                        'attributes' => [
                            'federal_district_id' => $federalDistrict->id,
                            'name'                => $regions[1]->name,
                            'description'         => $regions[1]->description,
                            'slug'                => $regions[1]->slug,
                            'active'              => $regions[1]->active,
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
                        ]
                    ],
                ]
            ]);
    }

    public function test_federal_districts_regions_patch_relationships()
    {
        /** @var FederalDistrict $federalDistricts */
        $federalDistricts = FederalDistrict::factory()->count(2)->create();
        foreach ($federalDistricts as $federalDistrict) {
            Region::factory()->count(3)->create([
                'federal_district_id' => $federalDistrict->id
            ]);
        }

        $regions = Region::all();

        $this->patchJson('/api/v1/federal-districts/' . $federalDistricts[0]->id . '/relationships/regions', [
            'data' => [
                [
                    'id' => $regions[3]->id,
                    'type' => Region::TYPE_RESOURCE,
                ],
                [
                    'id' => $regions[4]->id,
                    'type' => Region::TYPE_RESOURCE,
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(204);

        $this->assertEquals($federalDistricts[0]->regions->count(), 5);
    }
}
