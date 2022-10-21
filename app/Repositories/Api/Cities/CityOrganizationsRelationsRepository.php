<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;
use App\Models\Organization;

final class CityOrganizationsRelationsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id): mixed
    {
        return City::findOrFail($id)->organizations();
    }

    /**
     * @param array $data
     * @return void
     */
    public  function updateRelations(array $data): void
    {
        $organizations = [];

        foreach (data_get($data, 'data.*.id') as $organizationId) {
//            dd($organizationId);
            $organizations[] = Organization::findOrFail($organizationId);
        }

        City::findOrFail(data_get($data,'city_id'))->organizations()->saveMany($organizations);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroyRelatedModels(int $id): void
    {
        foreach (City::findOrFail($id)->organizations as $item) {
            $item->delete();
        }
    }
}
