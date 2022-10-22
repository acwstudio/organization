<?php

namespace Tests\Feature\Regions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionUpdateValidateTest extends TestCase
{
    use RefreshDatabase;

    public function test_region_store_attributes_validate()
    {
        $this->postJson('/api/v1/regions', [
            'data' => [
                'type' => '',
                'attributes' => [
                    'federal_district_id' => 3,
                    'name'                => 'Архангельская область',
                    'description'         => 7,
                    'slug'                => 'arhangelskaya-oblast',
                    'active'              => 'true',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.type field is required.',
                        'source'  => [
                            'pointer' => '/data/type',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The selected data.attributes.federal district id is invalid.',
                        'source'  => [
                            'pointer' => '/data/attributes/federal_district_id',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.description must be a string.',
                        'source'  => [
                            'pointer' => '/data/attributes/description',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.slug field is prohibited.',
                        'source'  => [
                            'pointer' => '/data/attributes/slug',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.active field must be true or false.',
                        'source'  => [
                            'pointer' => '/data/attributes/active',
                        ]
                    ]
                ]
            ]);

//        $this->assertDatabaseMissing('regions', [
//            'federal_district_id' => 3,
//            'name'                => 'Северо-западный федеральный округ',
//            'description'         => 7,
//            'slug'                => 'arhangelskaya-oblast',
//            'active'              => 'true',
//        ]);
    }
}
