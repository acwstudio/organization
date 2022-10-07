<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictDestroyPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsDestroyRelatedPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsStoreRelationPipe;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictRegionsUpdateRelationPipe;
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
                    FederalDistrictRegionsStoreRelationPipe::class
                ])
                ->thenReturn();

            DB::commit();

            return data_get($data, 'model');

        } catch(\Exception | \Throwable $e) {

            DB::rollBack();
            Log::error($e);
        }

        throw new \Exception('Script processing error. The method store of the Federal District has been canceled');
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

            $data = $this->pipeline
                ->send($data)
                ->through([
                    FederalDistrictUpdatePipe::class,
                    FederalDistrictRegionsUpdateRelationPipe::class
                ])
                ->thenReturn();

            \DB::commit();

            return true;

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);
        }

        throw new \Exception('Script processing error. The method update of the Federal District has been canceled');
    }

    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($id)
                ->through([
                    FederalDistrictRegionsDestroyRelatedPipe::class,
                    FederalDistrictDestroyPipe::class
                ])
                ->thenReturn();

            \DB::commit();

            return true;

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
        }

        throw new \Exception('Script processing error. The method destroy of the Federal District has been canceled');
    }
}
