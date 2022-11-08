<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\Region;
use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function indexRelations(int $id): HasMany
    {
        return $this->regionCitiesRelationsRepository->indexToManyRelationships($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        data_set($data, 'region_id', $id);

        $this->regionCitiesRelationsRepository->updateToManyRelationships($data);
    }
}
