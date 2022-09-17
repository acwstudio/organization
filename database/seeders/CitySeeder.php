<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\FederalDistrict;
use App\Models\Region;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('federal_districts')->truncate();
        DB::table('regions')->truncate();
        DB::table('cities')->truncate();

        Schema::enableForeignKeyConstraints();

        $geoDistricts = DB::connection('mysql_city')->table('geo_district')->get();
        $geoRegions = DB::connection('mysql_city')->table('geo_regions')->get();
        $geoCities = DB::connection('mysql_city')->table('geo_city')->get();

        foreach ($geoDistricts as $geoDistrict) {
            DB::table('federal_districts')->insert([
                'name' => $geoDistrict->name,
                'description' => '',
                'slug' => SlugService::createSlug(FederalDistrict::class, 'slug', $geoDistrict->name),
                'active' => true,
                'created_at' => now(),
            ]);
        }

        foreach ($geoRegions as $geoRegion) {

            $federalDistrictName = $geoDistricts->where('id',$geoRegion->district_id)->first()->name;

            DB::table('regions')->insert([
                'federal_district_id' => DB::table('federal_districts')->where('name', $federalDistrictName)->first()->id,
                'name' => $geoRegion->name,
                'description' => '',
                'slug' => SlugService::createSlug(Region::class, 'slug', $geoRegion->name),
                'active' => true,
                'created_at' => now(),
            ]);
        }

        foreach ($geoCities as $geoCity) {

            $regionName = $geoRegions->where('id',$geoCity->region_id)->first()->name;

            DB::table('cities')->insert([
                'region_id' => DB::table('regions')->where('name', $regionName)->first()->id,
                'name' => $geoCity->name,
                'description' => '',
                'slug' => SlugService::createSlug(City::class, 'slug', $geoCity->name),
                'active' => true,
                'created_at' => now(),
            ]);
        }

    }
}
