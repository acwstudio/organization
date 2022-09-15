<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Repositories\Api\CityRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class CityService
{
    /**
     * @var CityRepository
     */
    private CityRepository $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->cityRepository->index();
    }
}
