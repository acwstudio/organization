<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

trait IncludeRelatedEntitiesCollectionTrait
{
    /**
     * @param $request
     * @return MissingValue|Collection
     */
    private function mergeIncludedRelations($request): MissingValue|Collection
    {
        $includes = $this->collection->flatMap(function ($resource) use($request){
            return $resource->included($request);
        });

        return $includes->isNotEmpty() ? $includes : new MissingValue();
    }

}
