<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractCRUDService
{
    /**
     * @return QueryBuilder
     */
    abstract protected function index(): QueryBuilder;

    /**
     * @param array $data
     * @return Model
     */
    abstract protected function store(array $data): Model;

    /**
     * @param int $id
     * @return QueryBuilder
     */
    abstract protected function show(int $id): QueryBuilder;

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    abstract protected function update(array $data, int $id): void;

    /**
     * @param int $id
     * @return void
     */
    abstract protected function destroy(int $id): void;
}
