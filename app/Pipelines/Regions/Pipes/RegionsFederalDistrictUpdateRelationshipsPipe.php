<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;
use App\Repositories\Api\Regions\RegionsFederalDistrictRelationsRepository;

final class RegionsFederalDistrictUpdateRelationshipsPipe
{
    protected RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository;

    /**
     * @param RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository
     */
    public function __construct(RegionsFederalDistrictRelationsRepository $regionsFederalDistrictRelationsRepository)
    {
        $this->regionsFederalDistrictRelationsRepository = $regionsFederalDistrictRelationsRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $relationshipsData = data_get($data, 'data.relationships.federalDistrict');

        if ($relationshipsData) {

            data_set($relationshipsData, 'region_id', data_get($data, 'region_id'));

            $this->regionsFederalDistrictRelationsRepository->updateToOneRelationship($relationshipsData);
        }

        return $next($data);
    }
}
