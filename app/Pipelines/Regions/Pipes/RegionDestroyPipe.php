<?php

declare(strict_types=1);

namespace App\Pipelines\Regions\Pipes;

use App\Repositories\Api\Regions\RegionRepository;

final class RegionDestroyPipe
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
     * @param int $id
     * @param \Closure $next
     * @return mixed
     */
    public function handle(int $id, \Closure $next): mixed
    {
        $this->regionRepository->destroy($id);

        return $next($id);
    }
}
