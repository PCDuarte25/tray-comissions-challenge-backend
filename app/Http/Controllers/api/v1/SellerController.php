<?php

namespace App\Http\Controllers\api\v1;

use App\DTOs\SellerDataDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResendReportRequest;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Resources\SaleResource;
use App\Http\Resources\SellerResource;
use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use App\Services\ApiResponse;
use App\Services\ReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Controller for handling seller operations.
 */
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
     *
     * @return \App\Services\ApiResponse
     *   The response containing the list of sellers.
     */
    public function index()
    {
        $page = request()->get('page', 1);
        $cacheKey = "sellers_all_page_$page";
        $sellers = Cache::remember($cacheKey, 60, function () {
            return $this->sellerRepository->getAllSellersPaginated(20);
        });

        return ApiResponse::success([
            'data' => SellerResource::collection($sellers),
            'meta' => [
                'current_page' => $sellers->currentPage(),
                'last_page' => $sellers->lastPage(),
                'per_page' => $sellers->perPage(),
                'total' => $sellers->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSellerRequest $request
     *   The request containing the seller data.
     *
     * @return \App\Services\ApiResponse
     *   The response indicating success or failure.
     */
    public function store(StoreSellerRequest $request)
    {
        return $this->executeInTransaction(function() use ($request) {
            $sellerDto = SellerDataDto::fromRequest($request);
            $seller = $this->sellerRepository->createSeller($sellerDto);

            $page = request()->get('page', 1);
            Cache::forget("sellers_all_page_$page");
            Cache::forget("sellers_{$seller->id}");

            return ApiResponse::success([
                'seller' => $seller
            ], Response::HTTP_CREATED, 'Seller created successfully');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *   The ID of the seller to display.
     *
     * @return \App\Services\ApiResponse
     *   The response containing the seller information.
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

        return ApiResponse::success(new SellerResource($seller));
    }

    /**
     * Get the sales for a specific seller by their ID.
     *
     * @param string $id
     *   The ID of the seller.
     *
     * @return \App\Services\ApiResponse
     *  The response containing the sales information.
     */
    public function getSalesBySellerId(string $id)
    {
        return $this->executeInTransaction(function() use ($id) {
            $cacheKey = "sellers_{$id}_sales";
            $cacheTags = ['sales', 'sellers'];

            $sales = Cache::tags($cacheTags)->remember($cacheKey, 30, function () use ($id) {
                return $this->saleRepository->getSalesBySellerId($id);
            });

            return ApiResponse::success(
                SaleResource::collection($sales)
            );
        });
    }

    /**
     * Resend the report for a specific seller.
     *
     * @param \App\Http\Requests\ResendReportRequest $request
     *   The request containing the report data.
     * @param string $id
     *   The ID of the seller.
     *
     * @return \Illuminate\Http\JsonResponse
     *   The response indicating success or failure.
     */
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
