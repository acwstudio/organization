<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\Region;

final class RegionCitiesRelationsRepository
{
    public function indexRelations(string $relation, int $id)
    {
        return Region::findOrFail($id)->{$relation}();
    }

    /**
     * @param array $ids
     * @param string $relatedModel
     * @param Region $model
     * @return void
     */
    public  function updateRelations(array $ids, string $relatedModel, Region $model): void
    {
        foreach ($ids as $id) {
            $relModels[] = app()->$relatedModel::findOrFail($id);
        }

        $model->regions()->saveMany($relModels);
    }

    public function destroyRelatedModels($relation, Region $model)
    {
//        dd($model->{$relation});
        $model->cities->each->delete();
//        $model->{$relation}()->delete();
    }
}
