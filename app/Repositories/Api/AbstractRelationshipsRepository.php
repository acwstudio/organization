<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return HasMany
     */
    abstract public function indexToManyRelationships(int $id): HasMany;

    /**
     * @param int $id
     * @return Model
     */
    abstract public function indexToOneRelationships(int $id): Model;

    /**
     * @param array $data
     * @return void
     */
    abstract public function updateToManyRelationships(array $data): void;

    /**
     * @param array $data
     * @return void
     */
    abstract public function updateToOneRelationship(array $data): void;

    /**
     * @return void
     */
    abstract public function updateManyToManyRelationships(): void;
}
