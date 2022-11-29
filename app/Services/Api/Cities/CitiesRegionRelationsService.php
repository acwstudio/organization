<?php

declare(strict_types=1);

namespace App\Services\Api\Cities;

use App\Repositories\Api\Cities\CityRelationsRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CitiesRegionRelationsService
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
     * @param array $data
     * @return BelongsTo
     */
    public function indexRelations(array $data): BelongsTo
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
