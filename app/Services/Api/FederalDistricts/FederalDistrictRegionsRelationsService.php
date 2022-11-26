<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function indexRelations(array $data): HasMany
    {
        return $this->federalDistrictRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        $this->federalDistrictRelationsRepository->updateRelations($data);
    }
}
