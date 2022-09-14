<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;


trait IncludeRelatedEntitiesResourceTrait
{
    protected function prepareRelations()
    {
        $relations = $this->relations();

        /** @var ResourceCollection $key */
        /** @var Model|MissingValue|Collection $relation */
        foreach ($relations as $key => $relation) {
            if ($relation instanceof Model) {
                $newRelations[] = $key::collection([$relation]);
            }
            if ($relation instanceof MissingValue || $relation instanceof Collection) {
                $newRelations[] = $key::collection($relation);
            }
        }

        return $newRelations;
    }

    /**
     * @param $request
     * @return array|Collection
     */
    public function included($request): array|Collection
    {
        return collect($this->prepareRelations())
            ->filter(function ($resource) {
                return $resource->collection !== null;
            })
            ->flatMap(function ($resource) use ($request) {
                return $resource->flatten($request);
            });
    }

    /**
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        $with = [];

        if ($this->included($request)->isNotEmpty()) {
            $with['included'] = $this->included($request);
        }

        return $with;
    }

}
