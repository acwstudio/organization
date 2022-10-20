<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;
use App\Repositories\Api\Regions\RegionsFederalDisrtictRelationsRepository;

final class RegionsFederalDistrictUpdateRelationPipe
{
    protected RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository;

    /**
     * @param RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository
     */
    public function __construct(RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository)
    {
        $this->regionsFederalDisrtictRelationsRepository = $regionsFederalDisrtictRelationsRepository;
    }

    public function handle(array $data, \Closure $next)
    {
        $relationshipsData = data_get($data, 'data.relationships.federalDistrict');
        data_set($relationshipsData, 'region_id', data_get($data, 'region_id'));

        $this->regionsFederalDisrtictRelationsRepository->updateRelations($relationshipsData);

        return $next($data);
    }
}
