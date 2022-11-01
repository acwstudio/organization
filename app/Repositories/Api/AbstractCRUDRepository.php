<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractCRUDRepository
{
    /**
     * @return QueryBuilder
     */
    abstract public function index(): QueryBuilder;

    /**
     * @param array $data
     * @return Model
     */
    abstract public function store(array $data): Model;

    /**
     * @param int $id
     * @return QueryBuilder
     */
    abstract public function show(int $id): QueryBuilder;

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    abstract public function update(array $data, int $id): void;

    /**
     * @param int $id
     * @return void
     */
    abstract public function destroy(int $id): void;
}
