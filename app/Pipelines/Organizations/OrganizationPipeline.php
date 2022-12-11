<?php

declare(strict_types=1);

namespace App\Pipelines\Organizations;

use App\Pipelines\AbstractPipeline;
use App\Pipelines\Organizations\Pipes\OrganizationChildrenUpdateRelationshipsPipe;
use App\Pipelines\Organizations\Pipes\OrganizationDestroyPipe;
use App\Pipelines\Organizations\Pipes\OrganizationFacultiesUpdateRelationshipsPipe;
use App\Pipelines\Organizations\Pipes\OrganizationsCityUpdateRelationshipsPipe;
use App\Pipelines\Organizations\Pipes\OrganizationsOrganizationTypeUpdateRelationshipsPipe;
use App\Pipelines\Organizations\Pipes\OrganizationsParentUpdateRelationshipsPipe;
use App\Pipelines\Organizations\Pipes\OrganizationStorePipe;
use App\Pipelines\Organizations\Pipes\OrganizationUpdatePipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class OrganizationPipeline extends AbstractPipeline
{
    public function store(array $data): Model
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    OrganizationStorePipe::class,
//                    OrganizationsParentUpdateRelationshipsPipe::class,
//                    OrganizationFacultiesUpdateRelationshipsPipe::class,
//                    OrganizationChildrenUpdateRelationshipsPipe::class,
//                    OrganizationsCityUpdateRelationshipsPipe::class,
//                    OrganizationsOrganizationTypeUpdateRelationshipsPipe::class,
                ])
                ->thenReturn();

            DB::commit();

            return data_get($data, 'model');

        } catch(\Exception | \Throwable $e) {

            DB::rollBack();
            Log::error($e);

            throw ($e);
        }
    }

    public function update(array $data): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($data)
                ->through([
                    OrganizationUpdatePipe::class,
                    OrganizationsParentUpdateRelationshipsPipe::class,
                    OrganizationFacultiesUpdateRelationshipsPipe::class,
                    OrganizationChildrenUpdateRelationshipsPipe::class,
                    OrganizationsCityUpdateRelationshipsPipe::class,
                    OrganizationsOrganizationTypeUpdateRelationshipsPipe::class,
                ])
                ->thenReturn();

            \DB::commit();

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);

            throw ($e);
        }
    }

    public function destroy(int $id): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($id)
                ->through([
                    OrganizationDestroyPipe::class
                ])
                ->thenReturn();

            \DB::commit();

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);

            throw ($e);
        }
    }
}
