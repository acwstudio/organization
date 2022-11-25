<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;

final class FederalDistrictRegionsRelationsService
{
    protected FederalDistrictRelationsRepository $federalDistrictRelationsRepository;

    /**
     * @param FederalDistrictRelationsRepository $federalDistrictRelationsRepository
     */
    public function __construct(FederalDistrictRelationsRepository $federalDistrictRelationsRepository)
    {
        $this->federalDistrictRelationsRepository = $federalDistrictRelationsRepository;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function indexRelation(array $data): mixed
    {
        return $this->federalDistrictRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateRelations(array $data): void
    {
        $this->federalDistrictRelationsRepository->updateRelations($data);
    }

    /**
     * @param array $data
     * @return void
     */
    public function storeRelations(array $data): void
    {
        $this->federalDistrictRelationsRepository->storeRelations($data);
    }
}
