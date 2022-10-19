<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;

final class RegionCitiesDestroyRelatedPipe
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
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(int $id, \Closure $next): mixed
    {
        $this->regionCitiesRelationsRepository->destroyRelatedModels($id);

        return $next($id);
    }
}
