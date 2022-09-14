<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\OrganizationType;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationTypeRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(OrganizationType::class)
            ->allowedIncludes(['parent','children','organizations'])
            ->allowedFilters('')
            ->allowedSorts('');
    }
}
