<?php

declare(strict_types=1);

namespace App\Repositories\Api\Faculties;

use App\Models\Faculty;
use Spatie\QueryBuilder\QueryBuilder;

final class FacultyRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(Faculty::class)
            ->allowedFields(['id','organization_id','name'])
            ->allowedIncludes(['organization'])
            ->allowedFilters(['name','active'])
            ->allowedSorts(['name']);
    }

    /**
     * @param Faculty $faculty
     * @return QueryBuilder
     */
    public function show(Faculty $faculty): QueryBuilder
    {
        return QueryBuilder::for(Faculty::class)
            ->where('id', $faculty->id)
            ->allowedIncludes(['organization']);
    }
}
