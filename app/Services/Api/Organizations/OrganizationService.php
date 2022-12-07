<?php

declare(strict_types=1);

namespace App\Services\Api\Organizations;

use App\Models\Organization;
use App\Pipelines\Organizations\OrganizationPipeline;
use App\Repositories\Api\Organizations\OrganizationRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationService
{
    private OrganizationRepository $organizationRepository;
    private OrganizationPipeline $organizationPipeline;

    /**
     * @param OrganizationRepository $organizationRepository
     * @param OrganizationPipeline $organizationPipeline
     */
    public function __construct(OrganizationRepository $organizationRepository, OrganizationPipeline $organizationPipeline)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationPipeline = $organizationPipeline;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->organizationRepository->index();
    }

    /**
     * @param array $data
     * @return Model|Organization
     * @throws \Throwable
     */
    public function store(array $data): Model|Organization
    {
        return $this->organizationPipeline->store($data);
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
