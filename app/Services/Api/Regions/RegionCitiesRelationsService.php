<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Repositories\Api\Regions\RegionCitiesRelationsRepository;
use App\Repositories\Api\Regions\RegionsFederalDisrtictRelationsRepository;

final class RegionCitiesRelationsService
{
    protected RegionCitiesRelationsRepository $regionsCitiesRelationsRepository;

    /**
     * @param RegionCitiesRelationsRepository $regionsFederalDisrtictRelationsRepositor
     */
    public function __construct(RegionCitiesRelationsRepository $regionsCitiesRelationsRepository)
    {
        $this->regionsCitiesRelationsRepository = $regionsCitiesRelationsRepository;
    }
}
