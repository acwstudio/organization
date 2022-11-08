<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;
use App\Models\Organization;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class CityOrganizationsRelationsRepository extends AbstractRelationshipsRepository
{
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

    public function indexToManyRelationships(int $id): HasMany
    {
        return City::findOrFail($id)->organizations();
    }

    public function indexToOneRelationships(int $id): Model
    {
        // TODO: Implement indexToOneRelationships() method.
    }

    public function updateToManyRelationships(array $data): void
    {
        $organizationIds = data_get($data, 'data.*.id');
        $cityId = data_get($data,'city_id');

        if ($organizationIds) {
            foreach ($organizationIds as $organizationId) {
                Organization::findOrFail($organizationId)->update(['city_id' => $cityId]);
            }
        } else {
            foreach (City::findOrFail($cityId)->organizations as $organization) {
                $organization->update(['city_id' => null]);
            }
        }
    }

    public function updateToOneRelationship(array $data): void
    {
        // TODO: Implement updateToOneRelationship() method.
    }

    public function updateManyToManyRelationships(): void
    {
        // TODO: Implement updateManyToManyRelationships() method.
    }
}
