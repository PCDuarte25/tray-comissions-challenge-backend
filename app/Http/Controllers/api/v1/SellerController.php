<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SellerDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResendReportRequest;
use App\Http\Requests\StoreSellerRequest;
use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use App\Services\ApiResponse;
use App\Services\ReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    /**
     * Creates a new instance of the SellerController.
     */
    public function __construct(
        private SellerRepository $sellerRepository,
        private SaleRepository $saleRepository,
        private ReportService $reportService
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
        return $this->executeInTransaction(function() use ($request) {
            $sellerDto = SellerDataDto::fromRequest($request);
            $seller = $this->sellerRepository->createSeller($sellerDto);

            Cache::forget('sellers_all');
            Cache::forget("sellers_{$seller->id}");

            return ApiResponse::success([
                'seller' => $seller
            ], Response::HTTP_CREATED, 'Seller created successfully');
        });
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
        return $this->executeInTransaction(function() use ($id) {
            $cacheKey = "sellers_{$id}_sales";
            $cacheTags = ['sales', 'sellers'];

            // $sales = Cache::tags($cacheTags)->remember($cacheKey, 30, function () use ($id) {
            //     return $this->saleRepository->getSalesBySellerId($id);
            // });

            $sales = Cache::remember($cacheKey, 30, function () use ($id) {
                return $this->saleRepository->getSalesBySellerId($id);
            });

            return ApiResponse::success($sales->toArray());
        });
    }

    public function resendReport(ResendReportRequest $request, string $id)
    {
        try {
            if (!$seller = $this->sellerRepository->getSellerById($id)) {
                return ApiResponse::error('Seller not found', Response::HTTP_NOT_FOUND);
            }

            $data = $request->validated();

            $this->reportService->sendSellerReport(
                $seller,
                $data['date']
            );

            return ApiResponse::success([], Response::HTTP_OK, 'Report resent successfully');

        } catch (\Exception $e) {
            Log::error('Error resending report: ' . $e->getMessage());
            return ApiResponse::error(
                'Failed to resend report',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
