<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;

final class FederalDistrictStorePipe
{
    protected FederalDistrictRepository $federalDistrictRepository;

    /**
     * @param \App\Repositories\Api\FederalDistricts\FederalDistrictRepository $federalDistrictRepository
     */
    public function __construct(FederalDistrictRepository $federalDistrictRepository)
    {
        $this->federalDistrictRepository = $federalDistrictRepository;
    }

    /**
     * @param array $data
     * @param \Closure $next
     * @return mixed
     */
    public function handle(array $data, \Closure $next): mixed
    {
        $attributes = data_get($data, 'data.attributes');

        $federalDistricts = $this->federalDistrictRepository->store($attributes);

        $data = data_set($data, 'model', $federalDistricts);

        return $next($data);
    }
}
