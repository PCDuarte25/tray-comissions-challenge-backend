<?php

namespace App;

use App\Services\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * This trait provides a method to execute a callback within a database transaction.
 * If the callback fails, it rolls back the transaction and logs the error.
 */
trait HandlesTransactions
{
    /**
     * Execute a callback within a database transaction.
     *
     * @param callable $callback
     *   The callback to execute.
     * @param bool $returnResponse
     *   Whether to return an error response if the transaction fails.
     *
     * @return mixed
     *   The result of the callback or an error response.
     */
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
                return ApiResponse::error(
                    'Operation failed',
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    config('app.debug') ? $e->getMessage() : null
                );
            }

            throw $e;
        }
    }
}
