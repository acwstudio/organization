<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistrictRepository;

final class FederalDistrictStorePipeline
{
    protected FederalDistrictRepository $federalDistrictRepository;

    /**
     * @param FederalDistrictRepository $federalDistrictRepository
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

        $model = $this->federalDistrictRepository->store($attributes);

        $data = data_set($data, 'model', $model);

        return $next($data);
    }
}
