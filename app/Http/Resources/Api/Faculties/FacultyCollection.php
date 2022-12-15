<?php

namespace App\Http\Resources\Api\Faculties;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\Faculty;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FacultyCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * @return int
     */
    protected function total(): int
    {
        return Faculty::where('active', true)->count();
    }
}
