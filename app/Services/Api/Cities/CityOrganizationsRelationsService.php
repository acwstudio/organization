<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Repositories\Api\Cities\CityRelationshipsRepository;

final class CityOrganizationsRelationsService
{
    protected CityRelationshipsRepository $cityRelationsRepository;

    /**
     * @param CityRelationshipsRepository $cityRelationsRepository
     */
    public function __construct(CityRelationshipsRepository $cityRelationsRepository)
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
