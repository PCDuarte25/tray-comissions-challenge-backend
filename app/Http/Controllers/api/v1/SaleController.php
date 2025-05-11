<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SaleDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Repositories\SaleRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaleController extends Controller
{
    /**
     * Creates a new instance of the SaleController.
     */
    public function __construct(private SaleRepository $saleRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = $this->saleRepository->getAllSales();

        return ApiResponse::success($sales->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        $saleDto = SaleDataDto::fromRequest($request);

        $sale = $this->saleRepository->createSale($saleDto);

        return ApiResponse::success([
            'sale' => $sale
        ], Response::HTTP_CREATED, 'Sale created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = $this->saleRepository->getSaleById($id);

        if (!$sale) {
            return ApiResponse::error('Sale not found', Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::success($sale->toArray());
    }
}
