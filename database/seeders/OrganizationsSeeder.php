<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\OrganizationType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use phpDocumentor\Reflection\Types\Integer;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organizations')->truncate();
        DB::table('faculties')->truncate();

        Schema::enableForeignKeyConstraints();

        $organizations = Items::fromFile(public_path() . "/schools_fyi_aux.json");

        $i = 0;

        foreach ($organizations as $key => $organization) {
            $this->service($key, $organization);
//            dd($this->getOrganizationFaculties($key, $organization));
            $organizationFaculties = $this->getOrganizationFaculties($key, $organization);

            $organizationId = Str::uuid()->toString();

            DB::table('organizations')->insert([
                'id'                   => $organizationId,
                'parent_id'            => null,
                'city_id'              => $this->getCityId($organization),
                'organization_type_id' => $this->getOrganizationTypeId($organization),
                'name'                 => $organization->name,
                'abbreviation'         => '',
                'description'          => $organization->description[0],
                'site'                 => $organization->contacts->site,
                'email'                => $organization->contacts->mail,
                'phone'                => $organization->contacts->phone,
                'address'              => $organization->contacts->address,
                'slug'                 => SlugService::createSlug(OrganizationType::class, 'slug', $organization->name),
                'plaque_image'         => '',
                'preview_image'        => '',
                'base_image'           => '',
                'created_at'           => now(),
            ]);

            foreach ($organizationFaculties as $organizationFaculty) {
                $facultyId = DB::table('faculties')->insertGetId([
                    'organization_id' => $organizationId,
                    'name'            => $organizationFaculty,
                    'description'     => '',
                    'slug'            => SlugService::createSlug(OrganizationType::class, 'slug', $organizationFaculty),
                    'active'          => true,
                    'created_at'           => now(),
                ]);
            }
        }
    }

    private function getCityId($organization)
    {
        if ($organization->town === 'Малаховка') {
            return City::where('name', 'Люберцы')->first()->id;
        } elseif ($organization->town === 'Благовещенск') {
            return City::where('name', 'Благовещенск (Амурская область)')->first()->id;
        } elseif ($organization->town === 'Киров') {
            return City::where('name', 'Киров (Кировская область)')->first()->id;
        } elseif ($organization->town === 'Зеленоград') {
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
        } elseif (str_contains($organization->name, 'нститут')) {
            return OrganizationType::where('name', 'Институт')->first()->id;
        } elseif (str_contains($organization->name, 'ниверситет')) {
            return OrganizationType::where('name', 'Университет')->first()->id;
        } elseif (str_contains($organization->name, 'уховная кадемия')) {
            return OrganizationType::where('name', 'Духовная академия')->first()->id;
        } elseif (str_contains($organization->name, 'кадемия')) {
            return OrganizationType::where('name', 'Академия')->first()->id;
        } elseif (str_contains($organization->name, 'еминария')) {
            return OrganizationType::where('name', 'Духовная семинария')->first()->id;
        } elseif (str_contains($organization->name, 'кадемии')) {
            return OrganizationType::where('name', 'Академия')->first()->id;
        } elseif (str_contains($organization->name, 'онсерватория')) {
            return OrganizationType::where('name', 'Консерватория')->first()->id;
        } elseif (str_contains($organization->name, 'школа')) {
            return OrganizationType::where('name', 'Высшая школа')->first()->id;
        } else {
            return null;
        }
    }

    private function service($key, $value)
    {

        if (str_contains($value->name, 'Дальневосточный институт управления - филиал Российской академии народного хозяйства и государственной службы при Президенте Российской Федерации')) {
            dump($key . '  ' . $value->name);
        }

//        dump($this->getCityId($organization));
    }

    private function getOrganizationFaculties($key, $value)
    {
        $facultyNames = [];
//        if ($value) {
            foreach ($value->levels as $level) {
                foreach ($level->directions as $direction) {
                    foreach ($direction->faculties as $faculty) {
                        $facultyNames[] = $faculty->name;
                    }
                }
            }
//            dump(array_unique($facultyNames));
            return array_unique($facultyNames);
//            return $facultyNames ? array_unique($facultyNames): $facultyNames;
//        }

    }
}
