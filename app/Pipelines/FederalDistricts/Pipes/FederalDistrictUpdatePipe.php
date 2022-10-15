<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;

final class FederalDistrictUpdatePipe
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

        $id = data_get($data, 'id');

        $this->federalDistrictRepository->update($attributes, $id);

        return $next($data);
    }
}
