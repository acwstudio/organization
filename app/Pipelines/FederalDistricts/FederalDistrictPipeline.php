<?php

declare(strict_types=1);

namespace App\Pipelines\FederalDistricts;

use App\Models\FederalDistrict;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\FederalDistricts\Pipes\FederalDistrictStorePipeline;
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

            $data =$this->pipeline
                ->send($data)
                ->through([
                    FederalDistrictStorePipeline::class
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
}
