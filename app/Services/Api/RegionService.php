<?php

declare(strict_types=1);

namespace App\Services\Api;

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
}
