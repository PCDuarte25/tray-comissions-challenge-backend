<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SaleDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Resources\SaleResource;
use App\Repositories\ConfigurationRepository;
use App\Repositories\SaleRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Controller for handling sales operations.
 */
class SaleController extends Controller
{
    /**
     * Creates a new instance of the SaleController.
     */
    public function __construct(
        private SaleRepository $saleRepository,
        private ConfigurationRepository $configurationRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \App\Services\ApiResponse
     *   The response containing the list of sales.
     */
    public function index()
    {
        $cacheKey = 'sales_all';
        $sales = Cache::remember($cacheKey, 60, function () {
            return $this->saleRepository->getAllSales();
        });

        return ApiResponse::success(
            SaleResource::collection($sales)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSaleRequest $request
     *   The request containing the sale data.
     *
     * @return \App\Services\ApiResponse
     *   The response indicating success or failure.
     */
    public function store(StoreSaleRequest $request)
    {
        return $this->executeInTransaction(function() use ($request) {
            $commissionPct = $this->configurationRepository->getConfigurationByKey('commission_pct');
            $saleDto = SaleDataDto::fromRequest($request, $commissionPct);

            $sale = $this->saleRepository->createSale($saleDto);

            Cache::forget('sales_all');
            Cache::forget("sale_{$sale->id}");
            Cache::forget("seller_{$sale->seller_id}_sales");
            Cache::tags(['sales', 'sellers'])->flush();

            return ApiResponse::success([
                'sale' => $sale
            ], Response::HTTP_CREATED, 'Sale created successfully');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *   The ID of the sale to display.
     *
     * @return \App\Services\ApiResponse
     *   The response containing the sale details.
     */
    public function show(string $id)
    {
        $cacheKey = "sales_$id";
        $sale = Cache::remember($cacheKey, 60, function () use ($id) {
            return $this->saleRepository->getSaleById($id);
        });

        if (!$sale) {
            return ApiResponse::error('Sale not found', Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::success(new SaleResource($sale));
    }
}
