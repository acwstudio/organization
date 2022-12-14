<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

trait IncludeRelatedEntitiesResourceTrait
{
    /**
     * @var array $newRelations
     */
    protected array $newRelations = [];

    /**
     * relations array
     *
     * return [
     *      PersonCollection::class          => $this->whenLoaded('persons'),
     *      LevelCollection::class           => $this->whenLoaded('levels'),
     *      -----------------
     *      LandVersionResource::class     => $this->whenLoaded('landVersion'),
     * ];
     */

    abstract function relations(): array;

    /**
     * @return array
     */
    protected function prepareRelations(): array
    {
        $relations = $this->relations();
        $newRelations = [];

        /** @var ResourceCollection $key */
        /** @var Model|MissingValue|Collection $relation */
        foreach ($relations as $key => $relation) {

            if ($relation instanceof Model) {
                // set glob_id unique virtual attribute to exclude duplicates into included section
                $relation->setAttribute('glob_id',$relation->getTable() . '-' . $relation->id);

                $newRelations[] = $key::collection([$relation]);
            }
            if ($relation instanceof Collection) {
                $limitedRelations = $relation->take(config('api-settings.limit-included'));
                // set glob_id unique virtual attribute to exclude duplicates into included section
                foreach ($limitedRelations as $keyItem => $item) {
                    $item->setAttribute('glob_id', $item->getTable() . '-' . $item->id);
                }

                $newRelations[] = new $key($limitedRelations);
            }
            if ($relation instanceof MissingValue) {
                $newRelations[] = $key::collection($relation);
            }
        }

        return $newRelations;
    }

    /**
     * @return array|Collection
     */
    public function included(): array|Collection
    {
        return collect($this->prepareRelations())
            ->filter(function ($resource) {
                return $resource->collection !== null;
            })
            ->flatMap(function ($resource) {
                return $resource->flatten();
            });
    }

    /**
     * @param $request
     * @return array
     */
    public function with($request): array
    {
        $with = [];

        if ($this->included()->isNotEmpty()) {
            $with['included'] = $this->included();
        }

        return $with;
    }

    /**
     * @param Model|Collection|MissingValue $whenLoaded
     * @return Model|Collection|MissingValue
     */
    protected function relatedData(Model|Collection|MissingValue $whenLoaded): Model|Collection|MissingValue
    {
        if ($whenLoaded instanceof Collection) {
            return $whenLoaded->take(config('api-settings.limit-included'));
        }

        if ($whenLoaded instanceof Model) {
            return $whenLoaded;
        }

        return $whenLoaded;
    }

    /**
     * @param Model|Collection|MissingValue $whenLoaded
     * @return int
     */
    protected function totalRelatedData(Model|Collection|MissingValue $whenLoaded): int
    {
        if ($whenLoaded instanceof Collection) {
            return $whenLoaded->count();
        }

        return 0;
    }
}
