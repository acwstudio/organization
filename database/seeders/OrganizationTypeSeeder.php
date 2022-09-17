<?php

namespace Database\Seeders;

use App\Imports\OrganizationTypeImport;
use App\Models\OrganizationType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organization_types')->truncate();

        Schema::enableForeignKeyConstraints();

        $types = config('data-seed.organization-types');

        foreach ($types as $key_1 => $type) {
            $id_1 = DB::table('organization_types')->insertGetId([
                'parent_id' => null,
                'name' => $type['name'],
                'description' => $type['description'],
                'slug' => SlugService::createSlug(OrganizationType::class, 'slug', $type['name']),
                'active' => true,
                'level' => 0,
                'created_at' => now()
            ]);
            if (isset($type['sub_1'])) {
                foreach ($type['sub_1'] as $key => $item) {
                    $id_2 = DB::table('organization_types')->insertGetId([
                        'parent_id' => $id_1,
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'slug' => SlugService::createSlug(OrganizationType::class, 'slug', $item['name']),
                        'active' => true,
                        'level' => 1,
                        'created_at' => now()
                    ]);
                    if (isset($item['sub_2'])) {
                        foreach ($item['sub_2'] as $key_2 => $item_2) {
                            $id_3 = DB::table('organization_types')->insertGetId([
                                'parent_id' => $id_2,
                                'name' => $item_2['name'],
                                'description' => $item_2['description'],
                                'slug' => SlugService::createSlug(OrganizationType::class, 'slug', $item_2['name']),
                                'active' => true,
                                'level' => 2,
                                'created_at' => now()
                            ]);
                        }
                    }
                }
            }
        }
    }
}
