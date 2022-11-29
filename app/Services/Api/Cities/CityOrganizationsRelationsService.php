<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Repositories\Api\Cities\CityOrganizationsRelationsRepository;
use App\Repositories\Api\Cities\CityRelationsRepository;

final class CityOrganizationsRelationsService
{
    protected CityRelationsRepository $cityRelationsRepository;

    /**
     * @param CityRelationsRepository $cityRelationsRepository
     */
    public function __construct(CityRelationsRepository $cityRelationsRepository)
    {
        $this->cityRelationsRepository = $cityRelationsRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(array $data)
    {
        return $this->cityRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        $this->cityRelationsRepository->updateRelations($data);
    }
}
