<?php

declare(strict_types=1);

namespace App\Services\Api\OrganizationTypes;

use App\Repositories\Api\OrganizationTypes\OrganizationTypeRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationTypeService
{
    /**
     * @var OrganizationTypeRepository
     */
    private OrganizationTypeRepository $organizationTypeRepository;

    /**
     * @param OrganizationTypeRepository $organizationTypeRepository
     */
    public function __construct(OrganizationTypeRepository $organizationTypeRepository)
    {
        $this->organizationTypeRepository = $organizationTypeRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->organizationTypeRepository->index();
    }
}
