<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

use App\Models\FederalDistrict;
use App\Repositories\Api\FederalDistricts\FederalDistrictRepository;

final class FederalDistrictDestroyPipe
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
     * @param int $id
     * @param \Closure $next
     * @return mixed
     */
    public function handle(FederalDistrict $model, \Closure $next): mixed
    {
        $this->federalDistrictRepository->destroy($model);

        return $next($model);
    }
}
