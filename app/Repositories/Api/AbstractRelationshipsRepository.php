<?php

declare(strict_types=1);

namespace App\Repositories\Api;

abstract class AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    abstract public function indexRelationships(int $id): mixed;

    /**
     * @param array $data
     * @return void
     */
    abstract public function updateToManyRelationships(array $data): void;

    /**
     * @return void
     */
    abstract public function updateToOneRelationship(): void;

    /**
     * @return void
     */
    abstract public function updateManyToManyRelationships(): void;
}
