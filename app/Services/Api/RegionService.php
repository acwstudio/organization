<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Region;
use App\Repositories\Api\RegionRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class RegionService
{
    /**
     * @var RegionRepository
     */
    private RegionRepository $regionRepository;

    /**
     * @param RegionRepository $regionRepository
     */
    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository= $regionRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->regionRepository->index();
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        $item = Region::findOrFail($id);

        return $this->regionRepository->show($item);
    }
}
