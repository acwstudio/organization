<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\Region;
use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;

final class RegionCitiesRelationsService
{
    protected RegionCitiesRelationsRepository $regionCitiesRelationsRepository;

    /**
     * @param RegionCitiesRelationsRepository $regionCitiesRelationsRepository
     */
    public function __construct(RegionCitiesRelationsRepository $regionCitiesRelationsRepository)
    {
        $this->regionCitiesRelationsRepository = $regionCitiesRelationsRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id): mixed
    {
        return $this->regionCitiesRelationsRepository->indexRelations('cities', $id);
    }

    /**
     * @param array $data
     * @param string $relatedModel
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        $ids = data_get($data, 'data.*.id');

        $model = Region::findOrFail($id);

        $this->regionCitiesRelationsRepository->updateRelations($ids, $relatedModel, $model);
    }
}
