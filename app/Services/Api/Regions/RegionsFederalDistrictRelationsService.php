<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\FederalDistrict;
use App\Repositories\Api\Regions\RegionsFederalDistrictRelationsRepository;
use Illuminate\Database\Eloquent\Model;

final class RegionsFederalDistrictRelationsService
{
    protected RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository;

    /**
     * @param RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository
     */
    public function __construct(RegionsFederalDistrictRelationsRepository $regionsFederalDisrtictRelationsRepository)
    {
        $this->regionsFederalDisrtictRelationsRepository = $regionsFederalDisrtictRelationsRepository;
    }

    /**
     * @param int $id
     * @return Model|FederalDistrict
     */
    public function indexRelations(int $id): Model|FederalDistrict
    {
        return $this->regionsFederalDisrtictRelationsRepository->indexRelations($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateRelations(array $data, int $id): void
    {
        data_set($data, 'region_id', $id);

        $this->regionsFederalDisrtictRelationsRepository->updateRelations($data);
    }

    public function destroyRelations(int $id): void
    {

    }
}
