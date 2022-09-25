<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Organization;
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

    /**
     * @param string $id
     * @return QueryBuilder
     */
    public function show(string $id): QueryBuilder
    {
        $item = Organization::findOrFail($id);

        return $this->organizationRepository->show($item);
    }
}
