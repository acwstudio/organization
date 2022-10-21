<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;
use App\Repositories\Api\Regions\RegionsFederalDistrictRelationsRepository;

final class RegionsFederalDistrictUpdateRelationPipe
{
    protected RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository;

    /**
     * @param RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository
     */
    public function __construct(RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository)
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
