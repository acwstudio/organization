<?php

declare(strict_types=1);

namespace App\Repositories\Api\OrganizationTypes;

use App\Models\OrganizationType;
use App\Repositories\Api\AbstractCRUDRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationTypeRepository extends AbstractCRUDRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(OrganizationType::class)
            ->allowedFields(['id','parent_id','name'])
            ->allowedIncludes(['parent','children','organizations'])
            ->allowedFilters(['id','parent_id'])
            ->allowedSorts(['id','name']);
    }

    public function store(array $data): Model
    {
        // TODO: Implement store() method.
    }

    public function show(int $id): QueryBuilder
    {
        // TODO: Implement show() method.
    }

    public function update(array $data): Model
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $id): void
    {
        // TODO: Implement destroy() method.
    }
}
