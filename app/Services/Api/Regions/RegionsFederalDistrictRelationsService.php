<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Repositories\Api\Regions\RegionsFederalDisrtictRelationsRepository;

final class RegionsFederalDistrictRelationsService
{
    protected RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository;

    /**
     * @param RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository
     */
    public function __construct(RegionsFederalDisrtictRelationsRepository $regionsFederalDisrtictRelationsRepository)
    {
        $this->regionsFederalDisrtictRelationsRepository = $regionsFederalDisrtictRelationsRepository;
    }
}
