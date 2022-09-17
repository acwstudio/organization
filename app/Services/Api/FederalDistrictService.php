<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\FederalDistrict;
use App\Repositories\Api\FederalDistrictRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictService
{
    /**
     * @var FederalDistrictRepository
     */
    private FederalDistrictRepository $federalDistrictRepository;

    /**
     * @param FederalDistrictRepository $federalDistrictRepository
     */
    public function __construct(FederalDistrictRepository $federalDistrictRepository)
    {
        $this->federalDistrictRepository = $federalDistrictRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->federalDistrictRepository->index();
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        $item = FederalDistrict::findOrFail($id);

        return $this->federalDistrictRepository->show($item);
    }
}
