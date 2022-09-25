<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\OrganizationType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JsonMachine\Items;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organizations')->truncate();

        Schema::enableForeignKeyConstraints();

        $organizations = Items::fromFile(public_path() . "/schools_fyi_aux.json");
        $i = 0;
        foreach ($organizations as $key_org => $organization) {
//            dump(str_contains($organization->name, 'Университет'));
//            dump($organization->name);

            if (str_contains($organization->name, 'ниверситет')) {
                if (!str_contains($organization->name, 'илиал')) {
                    dump('**  ' . $organization->name . '  ' . $i++);
                    dump($organization->description);
//                    $cityId = City::where('name', $organization->town)->first()->id;
//                    dd(Str::uuid()->toString());
                    $organizationId = DB::table('organizations')->insertGetId([
                        'id' => Str::uuid()->toString(),
                        'parent_id' => null,
                        'city_id' => $this->getCityId($organization),
                        'organization_type_id' => $this->getOrganizationTypeId($organization),
                        'name' => $organization->name,
                        'abbreviation' => '',
                        'description' => $organization->description[0],
                        'site' => $organization->contacts->site,
                        'email' => $organization->contacts->mail,
                        'phone' => $organization->contacts->phone,
                        'address' => $organization->contacts->address,
                        'slug' => SlugService::createSlug(OrganizationType::class, 'slug', $organization->name),
                        'plaque_image' => '',
                        'preview_image' => '',
                        'base_image' => '',
                    ]);
//                    foreach ($organization->levels as $level) {
//                        dump('----  ' . $level->name);
//                        foreach ($level->directions as $direction) {
//                            dump('++++++  ' . $direction->name);
//                            foreach ($direction->faculties as $faculty) {
//                                dump('########  ' . $faculty->name);
//                                dump('########  ' . $faculty->spetialty);
//                            }
//                        }
//                    }
                }
            }
//            dump('**  ' . $organization->name);
//            foreach ($organization->levels as $level) {
//                dump('----  ' . $level->name);
//                foreach ($level->directions as $direction) {
//                    dump('++++++  ' . $direction->name);
//                    foreach ($direction->faculties as $faculty) {
//                        dump('########  ' . $faculty->name);
//                        dump('########  ' . $faculty->spetialty);
//                    }
//                }
//            }
            $this->getCityId($organization);
//            dump('                ');
//            dd('stop');
        }

        dd('ok');
    }

    private function getCityId($organization)
    {
        if ($organization->town === 'Малаховка') {
            return City::where('name', 'Люберцы')->first()->id;
        } elseif ($organization->town === 'Благовещенск') {
//            dump($organization->contacts);
            return City::where('name', 'Благовещенск (Амурская область)')->first()->id;
        } elseif ($organization->town === 'Киров') {
//            dump($organization->contacts);
            return City::where('name', 'Киров (Кировская область)')->first()->id;
        } elseif ($organization->town === 'Зеленоград') {
//            dump($organization->contacts);
            if (explode(' ', $organization->contacts->phone)[1] === '(800)') {
                return City::where('name', 'Москва')->first()->id;
            } else {
                return City::where('name', 'Солнечногорск')->first()->id;
            }
        } elseif ($organization->town === 'Большие Вяземы') {
            return City::where('name', 'Одинцово')->first()->id;
        } else {
            return City::where('name', $organization->town)->first()->id;
        }
    }

    private function getOrganizationTypeId($organization)
    {
        if (str_contains($organization->name, 'сследовательский')) {
            return OrganizationType::where('name', 'Национальный исследовательский университет')->first()->id;
        } elseif (str_contains($organization->name, 'едеральный')) {
            return OrganizationType::where('name', 'Федеральный университет')->first()->id;
        } elseif (str_contains($organization->name, 'Санкт-Петербургский государственный университет')
            && mb_strlen($organization->name) === 47) {
            return OrganizationType::where('name', 'Университет с особым статусом')->first()->id;
        } elseif (str_contains($organization->name, 'Московский государственный университет имени М.В. Ломоносова')) {
            return OrganizationType::where('name', 'Университет с особым статусом')->first()->id;
        } elseif (str_contains($organization->name, 'ниверситет')) {
            return OrganizationType::where('name', 'Университет')->first()->id;
        }
    }
}
