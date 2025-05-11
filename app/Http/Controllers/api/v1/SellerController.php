<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SellerDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Response;

class SellerController extends Controller
{
    /**
     * Creates a new instance of the SellerController.
     */
    public function __construct(
        private SellerRepository $sellerRepository,
        private SaleRepository $saleRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = $this->sellerRepository->getAllSellers();

        return ApiResponse::success($sellers->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellerRequest $request)
    {
        $sellerDto = SellerDataDto::fromRequest($request);

        $seller = $this->sellerRepository->createSeller($sellerDto);

        return ApiResponse::success([
            'seller' => $seller
        ], Response::HTTP_CREATED, 'Seller created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller = $this->sellerRepository->getSellerById($id);

        if (!$seller) {
            return ApiResponse::error('Seller not found', Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::success($seller->toArray());
    }

    /**
     * Display the sales of the specified seller.
     */
    public function getSalesBySellerId(string $id)
    {
        $seller = $this->sellerRepository->getSellerById($id);

        if (!$seller) {
            return ApiResponse::error('Seller not found', Response::HTTP_NOT_FOUND);
        }

        $sales = $this->saleRepository->getSalesBySellerId($seller->id);

        return ApiResponse::success($sales->toArray());
    }
}
