<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SellerDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

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
        $cacheKey = 'sellers_all';
        $sellers = Cache::remember($cacheKey, 60, function () {
            return $this->sellerRepository->getAllSellers();
        });

        return ApiResponse::success($sellers->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellerRequest $request)
    {
        $sellerDto = SellerDataDto::fromRequest($request);

        $seller = $this->sellerRepository->createSeller($sellerDto);

        Cache::forget('sellers_all');
        Cache::forget("sellers_{$seller->id}");

        return ApiResponse::success([
            'seller' => $seller
        ], Response::HTTP_CREATED, 'Seller created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cacheKey = "sellers_$id";

        $seller = Cache::remember($cacheKey, 60, function () use ($id) {
            return $this->sellerRepository->getSellerById($id);
        });

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
        if (!$seller = $this->sellerRepository->getSellerById($id)) {
            return ApiResponse::error('Seller not found', Response::HTTP_NOT_FOUND);
        }

        $cacheKey = "seller_{$id}_sales";
        $cacheTags = ['sales', 'sellers'];

        $sales = Cache::tags($cacheTags)->remember($cacheKey, 30, function () use ($id) {
            return $this->saleRepository->getSalesBySellerId($id);
        });

        $sales = $this->saleRepository->getSalesBySellerId($seller->id);

        return ApiResponse::success($sales->toArray());
    }
}
