<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;

final class CityOrganizationsRelationsService
{
    protected CityOrganizationsRelationsRepository $cityOrganizationsRelationsRepository;

    /**
     * @param CityOrganizationsRelationsRepository $cityOrganizationsRelationsRepository
     */
    public function __construct(CityOrganizationsRelationsRepository $cityOrganizationsRelationsRepository)
    {
        $this->cityOrganizationsRelationsRepository = $cityOrganizationsRelationsRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id)
    {
        return $this->cityOrganizationsRelationsRepository->indexRelations($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        data_set($data, 'city_id', $id);

        $this->cityOrganizationsRelationsRepository->updateRelations($data);
    }
}
