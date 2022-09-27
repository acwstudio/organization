<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use JsonMachine\Items;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = Items::fromFile(public_path() . "/schools_fyi_aux.json");

        ('ok');

        Schema::disableForeignKeyConstraints();

        DB::table('faculties')->truncate();

        Schema::enableForeignKeyConstraints();

        $academies = DB::table('organizations')
            ->where('organization_type_id', 24)
            ->get();
//        dd($academies);
        foreach ($academies as $academy) {
            dump($academy->name);
            $faculties_arr = [];
            foreach ($organizations as $organization) {
                if ($organization->name === $academy->name) {
                    $academy_id = DB::table('organizations')
                        ->where('name', $academy->name)
                        ->first()->id;
                    foreach ($organization->levels as $level) {
                        foreach ($level->directions as $key => $direction) {
                            dump($direction->name);
                            foreach ($direction->faculties as $faculty) {
                                dump('**  ' . $faculty->name);
                                dump('----  ' . $faculty->spetialty);
                                $faculties_arr[] = $faculty->name;
                            }
                        }

                        dump($organization->name);
//                        dd(array_unique($faculties_arr));
                    }
//                    dd($academy_id);
                }
            }
            foreach (array_unique($faculties_arr) as $item) {
                DB::table('faculties')->insertGetId([
                    'organization_id' => $academy_id,
                    'name'            => $item,
                    'description'     => '',
                    'slug'            => SlugService::createSlug(Faculty::class, 'slug', $item),
                    'active'          => true,
                    'created_at'      => now(),
                ]);
            }
        }
    }

    private function test($organizations)
    {
        $i = 0;
        $faculties_arr = [];
        foreach ($organizations as $organization) {
//            dump($i++);
//            if (str_contains($organization->name, 'Российский университет дружбы народов')) {
//            if (str_contains($organization->name, 'МИРЭА – Российский технологический университет')) {
//            if (str_contains($organization->name, 'Северо-Кавказская государственная академия')) {
//            if (str_contains($organization->name, 'Сочинский институт')) {
//            if (str_contains($organization->name, 'Пермская государственная фармацевтическая академия')) {
            if (str_contains($organization->name, 'Московская государственная академия физической культуры')) {
//            if (str_contains($organization->name, 'Институт мировой экономики и бизнеса')) {
//                dd($organization->levels[0]->directions);
                dump($organization->name);
                foreach ($organization->levels as $level) {
                    if ($level->name === 'Бакалавриат') {
//                        dump($level->directions);

                        foreach ($level->directions as $key => $direction) {
                            dump($direction->name);
                            foreach ($direction->faculties as $faculty) {
                                dump('**  ' . $faculty->name);
                                dump('----  ' . $faculty->spetialty);
                                $faculties_arr[] = $faculty->name;
                            }
                        }
                    }
                }
//                dump($organization->levels[2]->directions);

                dump(array_unique($faculties_arr));
            }
        }
    }
}
