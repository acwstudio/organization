<?php

declare(strict_types=1);

namespace App\Pipelines\Cities;

use App\Exceptions\PipelineException;
use App\Models\City;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\Cities\Pipes\CitiesRegionStoreRelationPipe;
use App\Pipelines\Cities\Pipes\CitiesRegionUpdateRelationPipe;
use App\Pipelines\Cities\Pipes\CityDestroyPipe;
use App\Pipelines\Cities\Pipes\CityOrganizationsDestroyRelatedPipe;
use App\Pipelines\Cities\Pipes\CityOrganizationsStoreRelationPipe;
use App\Pipelines\Cities\Pipes\CityOrganizationsUpdateRelationPipe;
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
                    CitiesRegionStoreRelationPipe::class,
                    CityOrganizationsStoreRelationPipe::class
                ])
                ->thenReturn();

            DB::commit();

            return data_get($data, 'model');
        } catch(\Exception | \Throwable $e) {

            DB::rollBack();
            Log::error($e);

            if ($e instanceof \PDOException){
                throw new PipelineException($e->getMessage(), (int)$e->getCode(), $e);
            } else {
                throw new \Exception($e->getMessage(), (int)$e->getCode(), $e);
            }
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Throwable
     */
    public function update(array $data): bool
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($data)
                ->through([
                    CityUpdatePipe::class,
                    CityOrganizationsUpdateRelationPipe::class,
                    CitiesRegionUpdateRelationPipe::class
                ])
                ->thenReturn();

            \DB::commit();

            return true;

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);

            if ($e instanceof \PDOException){
                throw new PipelineException($e->getMessage(), (int)$e->getCode(), $e);
            } else {
                throw new \Exception($e->getMessage(), (int)$e->getCode(), $e);
            }
        }
    }

    /**
     * @param array $data
     * @return void
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($id)
                ->through([
                    CityOrganizationsDestroyRelatedPipe::class,
                    CityDestroyPipe::class
                ])
                ->thenReturn();

            \DB::commit();

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);

            if ($e instanceof \PDOException){
                throw new PipelineException($e->getMessage(), (int)$e->getCode(), $e);
            } else {
                throw new \Exception($e->getMessage(), (int)$e->getCode(), $e);
            }
        }
    }
}
