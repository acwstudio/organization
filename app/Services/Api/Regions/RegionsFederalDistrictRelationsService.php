<?php

declare(strict_types=1);

namespace App\Services\Api\Regions;

use App\Models\FederalDistrict;
use App\Repositories\Api\Regions\RegionsFederalDisrtictRelationsRepository;
use Illuminate\Database\Eloquent\Model;

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
