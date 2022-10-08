<?php

declare(strict_types=1);

namespace App\Pipelines\Regions;

use App\Models\Region;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\Regions\Pipes\RegionStorePipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RegionPipeline extends AbstractPipeline
{
    public function store(array $data): Region
    {
        try {
            DB::beginTransaction();

            $data = $this->pipeline
                ->send($data)
                ->through([
                    RegionStorePipe::class
                ])
                ->thenReturn();

            DB::commit();

            return data_get($data, 'model');
        } catch(\Exception | \Throwable $e) {

            DB::rollBack();
            Log::error($e);
        }

        throw new \Exception('Script processing error. The method store of the Region has been canceled');
    }
}
