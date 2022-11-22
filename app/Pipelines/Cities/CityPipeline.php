<?php

declare(strict_types=1);

namespace App\Pipelines\Cities;

use App\Exceptions\PipelineException;
use App\Models\City;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\Cities\Pipes\CitiesRegionUpdateRelationshipsPipe;
use App\Pipelines\Cities\Pipes\CityDestroyPipe;
use App\Pipelines\Cities\Pipes\CityOrganizationsDestroyRelatedPipe;
use App\Pipelines\Cities\Pipes\CityOrganizationsUpdateRelationshipsPipe;
use App\Pipelines\Cities\Pipes\CityStorePipe;
use App\Pipelines\Cities\Pipes\CityUpdatePipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class CityPipeline  extends AbstractPipeline
{
    public function store(array $data): City
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    CityStorePipe::class,
                    CitiesRegionUpdateRelationshipsPipe::class,
                    CityOrganizationsUpdateRelationshipsPipe::class
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

    /**
     * @param array $data
     * @return void
     * @throws PipelineException
     * @throws \Throwable
     */
    public function update(array $data): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($data)
                ->through([
                    CityUpdatePipe::class,
                    CityOrganizationsUpdateRelationshipsPipe::class,
                    CitiesRegionUpdateRelationshipsPipe::class
                ])
                ->thenReturn();

            \DB::commit();

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);

            throw ($e);
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws PipelineException
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($id)
                ->through([
                    CityDestroyPipe::class
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
