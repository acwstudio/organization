<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\City;
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

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        $item = City::findOrFail($id);

        return $this->cityRepository->show($item);
    }
}
