<?php

declare(strict_types=1);

namespace App\Pipelines\Cities\Pipes;

use App\Repositories\Api\Cities\CitiesRegionRelationsRepository;

final class CitiesRegionStoreRelationPipe
{
    protected CitiesRegionRelationsRepository $citiesRegionRelationsRepository;

    /**
     * @param CitiesRegionRelationsRepository $citiesRegionRelationsRepository
     */
    public function __construct(CitiesRegionRelationsRepository $citiesRegionRelationsRepository)
    {
        $this->citiesRegionRelationsRepository = $citiesRegionRelationsRepository;
    }

    public function handle(array $data, \Closure $next): mixed
    {
        // to do something

        return $next($data);
    }
}
