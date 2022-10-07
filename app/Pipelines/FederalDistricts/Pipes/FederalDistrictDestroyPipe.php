<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts\Pipes;

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
    public function handle(int $id, \Closure $next): mixed
    {
        $this->federalDistrictRepository->destroy($id);

        return $next($id);
    }
}
