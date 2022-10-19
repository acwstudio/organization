<?php

declare(strict_types=1);

namespace App\Pipelines\Regions;

use App\Models\Region;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\Regions\Pipes\RegionCitiesDestroyRelatedPipe;
use App\Pipelines\Regions\Pipes\RegionCitiesStoreRelationPipe;
use App\Pipelines\Regions\Pipes\RegionCitiesUpdateRelationPipe;
use App\Pipelines\Regions\Pipes\RegionDestroyPipe;
use App\Pipelines\Regions\Pipes\RegionsFederalDistrictStoreRelationPipe;
use App\Pipelines\Regions\Pipes\RegionsFederalDistrictUpdateRelationPipe;
use App\Pipelines\Regions\Pipes\RegionStorePipe;
use App\Pipelines\Regions\Pipes\RegionUpdatePipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RegionPipeline extends AbstractPipeline
{
    public function store(array $data): Model|Region
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    RegionStorePipe::class,
                    RegionsFederalDistrictStoreRelationPipe::class,
                    RegionCitiesStoreRelationPipe::class
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
                    RegionsFederalDistrictUpdateRelationPipe::class,
                    RegionCitiesUpdateRelationPipe::class
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
                    RegionCitiesDestroyRelatedPipe::class,
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
