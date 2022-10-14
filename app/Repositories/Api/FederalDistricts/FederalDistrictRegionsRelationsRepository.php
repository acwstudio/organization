<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;

final class FederalDistrictRegionsRelationsRepository
{
    /**
     * @param string $relation
     * @param int $id
     * @return mixed
     */
    public function indexRelations(string $relation, int $id): mixed
    {
        return FederalDistrict::findOrFail($id)->{$relation}();
    }

    /**
     * @param array $ids
     * @param string $relatedModel
     * @param FederalDistrict $model
     * @return void
     */
    public  function updateRelations(array $ids, string $relatedModel, FederalDistrict $model): void
    {
        foreach ($ids as $id) {
            $relModels[] = app()->$relatedModel::findOrFail($id);
        }

        $model->regions()->saveMany($relModels);
    }

    /**
     * @param $relation
     * @param FederalDistrict $model
     * @return void
     */
    public function destroyRelatedModels($relation, FederalDistrict $model): void
    {
//        foreach ($model->$relation as $item) {
//            $item->delete();
//        }
        $model->{$relation}()->delete();
    }
}
