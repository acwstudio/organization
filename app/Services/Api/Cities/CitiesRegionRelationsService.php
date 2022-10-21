<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Models\Region;
use App\Repositories\Api\Cities\CitiesRegionRelationsRepository;
use Illuminate\Database\Eloquent\Model;

final class CitiesRegionRelationsService
{
    protected CitiesRegionRelationsRepository $citiesRegionRelationsRepository;

    /**
     * @param CitiesRegionRelationsRepository $citiesRegionRelationsRepository
     */
    public function __construct(CitiesRegionRelationsRepository $citiesRegionRelationsRepository)
    {
        $this->citiesRegionRelationsRepository = $citiesRegionRelationsRepository;
    }

    /**
     * @param int $id
     * @return Model|Region
     */
    public function indexRelations(int $id): Model|Region
    {
        return $this->citiesRegionRelationsRepository->indexRelations($id);
    }

    public function updateRelations(array $data, int $id): void
    {
        data_set($data, 'city_id', $id);

        $this->citiesRegionRelationsRepository->updateRelations($data);
    }
}
