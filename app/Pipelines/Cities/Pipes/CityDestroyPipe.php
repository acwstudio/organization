<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityRepository;

final class CityDestroyPipe
{
    protected CityRepository $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param int $id
     * @param \Closure $next
     * @return mixed
     */
    public function handle(int $id, \Closure $next): mixed
    {
        $this->cityRepository->destroy($id);

        return $next($id);
    }
}
