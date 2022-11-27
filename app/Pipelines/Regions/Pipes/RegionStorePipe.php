<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;

final class RegionStorePipe
{
    protected RegionRepository $regionRepository;

    /**
     * @param RegionRepository $regionRepository
     */
    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $model = $this->regionRepository->store($data);
        data_set($data, 'model', $model);
        data_set($data, 'id', $model->id);

        return $next($data);
    }
}
