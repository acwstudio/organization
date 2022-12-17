<?php

declare(strict_types=1);

namespace App\Services\Api\Organizations;

use App\Repositories\Api\Organizations\OrganizationRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class OrganizationChildrenRelationsService
{
    protected OrganizationRelationshipsRepository $organizationRelationsRepository;

    /**
     * @param OrganizationRelationshipsRepository $organizationRelationsRepository
     */
    public function __construct(OrganizationRelationshipsRepository $organizationRelationsRepository)
    {
        $this->organizationRelationsRepository = $organizationRelationsRepository;
    }

    /**
     * @param int $id
     * @return HasMany
     */
    public function indexRelations(array $data): HasMany
    {
        return $this->organizationRelationsRepository->indexRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        $this->organizationRelationsRepository->updateRelations($data);
    }
}
