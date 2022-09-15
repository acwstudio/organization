<?php

declare(strict_types=1);

namespace App\Services\Api;

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
}
