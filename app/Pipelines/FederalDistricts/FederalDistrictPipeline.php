<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts;

use App\Exceptions\PipelineException;
use App\Models\FederalDistrict;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictDestroyPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsDestroyRelatedPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsStoreRelationPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsUpdateRelationPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictStorePipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictUpdatePipe;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class FederalDistrictPipeline extends AbstractPipeline
{
    /**
     * @param array $data
     * @return FederalDistrict
     * @throws \Throwable
     */
    public function store(array $data): FederalDistrict
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    FederalDistrictStorePipe::class,
                    FederalDistrictRegionsStoreRelationPipe::class
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
     * @return bool
     * @throws \Throwable
     */
    public function update(array $data): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($data)
                ->through([
                    FederalDistrictUpdatePipe::class,
                    FederalDistrictRegionsUpdateRelationPipe::class
                ])
                ->thenReturn();

            DB::commit();

        } catch (\Exception | \Throwable $e) {
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
    public function destroy(int $id): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($id)
                ->through([
                    FederalDistrictRegionsDestroyRelatedPipe::class,
                    FederalDistrictDestroyPipe::class
                ])
                ->thenReturn();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);

            throw ($e);
        }
    }
}
