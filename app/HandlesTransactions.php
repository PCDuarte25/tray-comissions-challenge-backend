<?php

namespace App;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HandlesTransactions
{
    protected function executeInTransaction(callable $callback, bool $returnResponse = true)
    {
        DB::beginTransaction();

        try {
            $result = $callback();
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollBack();
            $className = get_class($this);
            Log::error("Transaction failed in {$className}: {$e->getMessage()}", [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            if ($returnResponse) {
                return app('App\Services\ApiResponse')->error(
                    'Operation failed',
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    config('app.debug') ? $e->getMessage() : null
                );
            }

            throw $e;
        }
    }
}
