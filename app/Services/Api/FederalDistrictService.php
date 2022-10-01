<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\FederalDistrict;
use App\Pipelines\FederalDistricts\FederalDistrictPipeline;
use App\Repositories\Api\FederalDistrictRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictService
{
    /**
     * @var FederalDistrictRepository
     */
    private FederalDistrictRepository $federalDistrictRepository;

    private FederalDistrictPipeline $federalDistrictPipeline;

    /**
     * @param FederalDistrictRepository $federalDistrictRepository
     */
    public function __construct(
        FederalDistrictRepository $federalDistrictRepository, FederalDistrictPipeline $federalDistrictPipeline
    )
    {
        $this->federalDistrictRepository = $federalDistrictRepository;
        $this->federalDistrictPipeline = $federalDistrictPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->federalDistrictRepository->index();
    }

    /**
     * @param array $data
     * @return Model|FederalDistrict
     */
    public function store(array $data): Model|FederalDistrict
    {
        return $this->federalDistrictPipeline->store($data);
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
