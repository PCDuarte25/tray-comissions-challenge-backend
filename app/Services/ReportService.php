<?php

namespace App\Services;

use App\Jobs\SendAdminReportJob;
use App\Jobs\SendSellerReportJob;
use App\Models\Seller;
use App\Models\User;
use App\Repositories\SellerRepository;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Log;

/**
 * This service is responsible for generating and sending reports to sellers and admins.
 */
class ReportService implements ReportServiceInterface
{
    /**
     * Creates a new instance of the ReportService.
     */
    public function __construct(
        private SellerRepository $sellerRepository,
        private SaleRepository $saleRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function sendDailyReports(string $date): void
    {
        $sales = $this->saleRepository->getUnreportedSalesByDate($date);

        if ($sales->isEmpty()) {
            Log::info("No unreported sales found for date {$date}");
            return;
        }

        $sales->groupBy('seller_id')->each(function ($group) use ($date) {
            $seller = $group->first()->seller;

            $this->sendSellerReport($seller, $date);
        });

        $this->saleRepository->markSalesAsReported($sales->pluck('id')->toArray());
    }

    /**
     * @inheritDoc
     */
    public function sendSellerReport(Seller $seller, string $date): void
    {
        try {
            $sales = $this->saleRepository->getSalesBySellerIdFromDate(
                $seller->id,
                $date
            );

            if ($sales->isEmpty()) {
                Log::info("No sales found for seller {$seller->id} on {$date}");
                return;
            }

            SendSellerReportJob::dispatch(
                $seller,
                $sales->count(),
                $sales->sum('value'),
                $sales->sum('commission'),
                $date
            );

        } catch (\Exception $e) {
            Log::error("Failed to send report for seller {$seller->id}: " . $e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function sendAdminReportData(string $date): void
    {
        $sales = $this->saleRepository->getAllSales();

        User::all()->each(function ($user) use ($sales, $date) {
            SendAdminReportJob::dispatch(
                $user,
                $sales->sum('value'),
                $date
            );
        });
    }
}
