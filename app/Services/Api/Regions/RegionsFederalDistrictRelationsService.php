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

    public function updateRelations(array $data, int $id)
    {
        $relatedId = data_get($data, 'data.id');

        $this->regionsFederalDisrtictRelationsRepository->updateRelations($relatedId, $id);
    }

    public function destroyRelations()
    {

    }
}
