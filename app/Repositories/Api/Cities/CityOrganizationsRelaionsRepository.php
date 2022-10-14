<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;

final class CityOrganizationsRelaionsRepository
{
    /**
     * @param string $relation
     * @param int $id
     * @return mixed
     */
    public function indexRelations(string $relation, int $id): mixed
    {
        return City::findOrFail($id)->{$relation}();
    }

    /**
     * @param array $ids
     * @param string $relatedModel
     * @param City $model
     * @return void
     */
    public  function updateRelations(array $ids, string $relatedModel, City $model): void
    {
        foreach ($ids as $id) {
            $relModels[] = app()->$relatedModel::findOrFail($id);
        }

        $model->regions()->saveMany($relModels);
    }

    /**
     * @param $relation
     * @param City $model
     * @return void
     */
    public function destroyRelatedModels($relation, City $model): void
    {
//        foreach ($model->$relation as $item) {
//            $item->delete();
//        }
        $model->{$relation}()->delete();
    }
}
