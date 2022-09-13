<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\Organization;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(Organization::class)
            ->allowedIncludes([''])
            ->allowedFilters([''])
            ->allowedSorts(['']);
    }
}
