<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;


trait IncludeRelatedEntitiesResourceTrait
{
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
                $newRelations[] = $key::collection([$relation->setAttribute('glob_id',$relation->getTable() . '-' . $relation->id)]);
            }
            if ($relation instanceof Collection) {
                foreach ($relation as $keyItem => $item) {
                    $item->setAttribute('glob_id',$item->getTable() . '-' . $item->id);
                }

                $newRelations[] = new $key($relation);
            }
            if ($relation instanceof MissingValue) {
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

    /**
     * relations array
     * for ProductResource example
     *
     * return [
     *      PersonResource::class          => $this->whenLoaded('persons'),
     *      LevelResource::class           => $this->whenLoaded('levels'),
     *      FormatResource::class          => $this->whenLoaded('formats'),
     *      ProductPlaceResource::class    => $this->whenLoaded('productPlaces'),
     *      OfferResource::class           => $this->whenLoaded('offers'),
     *      EntitySectionResource::class   => $this->whenLoaded('entitySection'),
     *      ProductTypeResource::class     => $this->whenLoaded('productType'),
     *      CategoryResource::class        => $this->whenLoaded('category'),
     *      OrganizationResource::class    => $this->whenLoaded('organization'),
     *      FacultyResource::class         => $this->whenLoaded('faculty'),
     *      SeoTagResource::class          => $this->whenLoaded('seoTag'),
     *      LandVersionResource::class     => $this->whenLoaded('landVersion'),
     * ];
     */

    abstract function relations(): array;
}
