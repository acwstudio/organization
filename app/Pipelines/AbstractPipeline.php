<?php

declare(strict_types=1);

namespace App\Pipelines;

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
}
