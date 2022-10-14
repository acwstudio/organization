<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CityRepository;

final class CityDestroyPipe
{
    protected CityRepository $cityRepository;

    /**
     * @param CityRepository $regionRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $this->cityRepository->destroy($data);

        return $next($data);
    }
}
