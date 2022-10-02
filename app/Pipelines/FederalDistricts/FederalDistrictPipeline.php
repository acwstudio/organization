<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\AbstractPipeline;
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
                    FederalDistrictStorePipe::class
                ])
                ->thenReturn();

            DB::commit();

            return data_get($data, 'model');

        } catch(\Exception | \Throwable $e) {

            DB::rollBack();
            Log::error($e);
        }

        throw new \Exception('Script processing error');
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
                    FederalDistrictUpdatePipe::class
                ])
                ->thenReturn();

            \DB::commit();

            return true;

        } catch (\Exception | \Throwable $e) {
            \DB::rollBack();
            \Log::error($e);
        }

        throw new \Exception('Script processing error');
    }
}
