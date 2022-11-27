<?php

declare(strict_types=1);

namespace App\Pipelines\Regions;

use App\Models\Region;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\Regions\Pipes\RegionCitiesStoreRelationshipsPipe;
use App\Pipelines\Regions\Pipes\RegionCitiesUpdateRelationshipsPipe;
use App\Pipelines\Regions\Pipes\RegionDestroyPipe;
use App\Pipelines\Regions\Pipes\RegionsFederalDistrictStoreRelationshipsPipe;
use App\Pipelines\Regions\Pipes\RegionsFederalDistrictUpdateRelationshipsPipe;
use App\Pipelines\Regions\Pipes\RegionStorePipe;
use App\Pipelines\Regions\Pipes\RegionUpdatePipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RegionPipeline extends AbstractPipeline
{
    /**
     * @param array $data
     * @return Region
     * @throws \Throwable
     */
    public function store(array $data): Region
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    RegionStorePipe::class,
                    RegionsFederalDistrictStoreRelationshipsPipe::class,
                    RegionCitiesStoreRelationshipsPipe::class
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
                    RegionUpdatePipe::class,
                    RegionsFederalDistrictUpdateRelationshipsPipe::class,
                    RegionCitiesUpdateRelationshipsPipe::class
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
     * @throws \Throwable
     */
    public function destroy(int $id): void
    {
        try {
            DB::beginTransaction();

            $this->pipeline
                ->send($id)
                ->through([
                    RegionDestroyPipe::class
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
