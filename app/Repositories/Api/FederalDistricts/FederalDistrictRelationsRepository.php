<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use Illuminate\Database\Eloquent\Model;

final class FederalDistrictRelationsRepository
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
    public  function saveRelations(array $ids, string $relatedModel, FederalDistrict $model): void
    {
        foreach ($ids as $id) {
            $relModels[] = app()->$relatedModel::findOrFail($id);
        }

        $model->regions()->saveMany($relModels);
    }

    public function destroyRelatedModels(int $id)
    {
        FederalDistrict::findOrFail($id)->regions()->delete();
    }
}
