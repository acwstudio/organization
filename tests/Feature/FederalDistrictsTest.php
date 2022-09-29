<?php

namespace Tests\Feature;

use App\Models\FederalDistrict;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FederalDistrictsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_federal_districts_resource_collection(): void
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->count(3)->create();

        $this->getJson('/api/v1/federal-districts',[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id'   => $federalDistrict[0]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name'        => $federalDistrict[0]->name,
                            'description' => $federalDistrict[0]->description,
                            'slug'        => $federalDistrict[0]->slug,
                            'active'      => $federalDistrict[0]->active,
                            'created_at'  => $federalDistrict[0]->created_at->toJSON()
                        ]
                    ],
                    [
                        'id'   => $federalDistrict[1]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name'        => $federalDistrict[1]->name,
                            'description' => $federalDistrict[1]->description,
                            'slug'        => $federalDistrict[1]->slug,
                            'active'      => $federalDistrict[1]->active,
                            'created_at'  => $federalDistrict[1]->created_at->toJSON()
                        ]
                    ],
                    [
                        'id'   => $federalDistrict[2]->id,
                        'type' => FederalDistrict::TYPE_RESOURCE,
                        'attributes' => [
                            'name'        => $federalDistrict[2]->name,
                            'description' => $federalDistrict[2]->description,
                            'slug'        => $federalDistrict[2]->slug,
                            'active'      => $federalDistrict[2]->active,
                            'created_at'  => $federalDistrict[2]->created_at->toJSON()
                        ]
                    ]
                ]
            ]);
    }

    public function test_get_federal_districts_resource()
    {
        /** @var FederalDistrict $federalDistrict */
        $federalDistrict = FederalDistrict::factory()->create();

        $this->getJson('/api/v1/federal-districts/' . $federalDistrict->id,[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'   => $federalDistrict->id,
                    'type' => FederalDistrict::TYPE_RESOURCE,
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
}
