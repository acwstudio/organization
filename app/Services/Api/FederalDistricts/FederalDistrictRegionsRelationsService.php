<?php

declare(strict_types=1);

namespace App\Services\Api\FederalDistricts;

use App\Repositories\Api\FederalDistricts\FederalDistrictRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class FederalDistrictRegionsRelationsService
{
    protected FederalDistrictRelationshipsRepository $federalDistrictRelationsRepository;

    /**
     * @param FederalDistrictRelationshipsRepository $federalDistrictRelationsRepository
     */
    public function __construct(FederalDistrictRelationshipsRepository $federalDistrictRelationsRepository)
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
