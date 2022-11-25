<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictDestroyPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsStoreRelationshipsPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsUpdateRelationshipsPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictStorePipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictUpdatePipe;
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
                    FederalDistrictRegionsStoreRelationshipsPipe::class
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
                    FederalDistrictRegionsUpdateRelationshipsPipe::class
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
     * @param int $id
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
