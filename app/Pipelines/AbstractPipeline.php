<?php

declare(strict_types=1);

namespace App\Pipelines;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

abstract class AbstractPipeline
{
    protected Pipeline $pipeline;

    /**
     * @param Pipeline $pipeline
     */
    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * @return Model
     */
    abstract protected function store(array $data): Model;

    /**
     * @return void
     */
    abstract protected function update(array $data): void;

    /**
     * @return void
     */
    abstract protected function destroy(int $id): void;
}
