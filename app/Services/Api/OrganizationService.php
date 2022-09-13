<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Repositories\Api\OrganizationRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationService
{
    private OrganizationRepository $organizationRepository;

    /**
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->organizationRepository->index();
    }
}
