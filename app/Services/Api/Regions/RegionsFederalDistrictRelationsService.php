<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Repositories\Api\Regions\RegionRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionsFederalDistrictRelationsService
{
    protected RegionRelationshipsRepository $regionRelationsRepository;

    /**
     * @param RegionRelationshipsRepository $regionRelationsRepository
     */
    public function __construct(RegionRelationshipsRepository $regionRelationsRepository)
    {
        $this->regionRelationsRepository = $regionRelationsRepository;
    }

    /**
     * @param array $data
     * @return HasMany
     */
    public function indexRelations(array $data): BelongsTo
    {
        return $this->regionRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        $this->regionRelationsRepository->updateRelations($data);
    }
}
