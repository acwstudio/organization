<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;

final class FederalDistrictRegionsRelationsRepository
{
    public function indexRelations(string $relation, int $id)
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

    public function destroyRelatedModels($relation, FederalDistrict $model)
    {
        $model->{$relation}()->delete();
    }
}
