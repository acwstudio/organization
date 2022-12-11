<?php

declare(strict_types=1);

namespace App\Services\Api\Organizations;

use App\Repositories\Api\Organizations\OrganizationRelationsRepository;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class OrganizationsParentRelationsService
{
    protected OrganizationRelationsRepository $organizationRelationsRepository;

    /**
     * @param OrganizationRelationsRepository $organizationRelationsRepository
     */
    public function __construct(OrganizationRelationsRepository $organizationRelationsRepository)
    {
        $this->organizationRelationsRepository = $organizationRelationsRepository;
    }

    /**
     * @param array $data
     * @return HasOne
     */
    public function indexRelations(array $data): HasOne
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
