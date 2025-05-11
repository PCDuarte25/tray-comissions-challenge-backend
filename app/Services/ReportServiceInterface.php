<?php

namespace App\Services;

use App\Models\Seller;

interface ReportServiceInterface
{
    /**
     * Sends daily reports to sellers and marks sales as reported.
     *
     * @param string $date
     *   The date for which the reports are generated.
     */
    public function sendDailyReports(string $date): void;

    /**
     * Sends a report to a specific seller.
     *
     * @param \App\Models\Seller $seller
     *   The seller to whom the report is sent.
     * @param string $date
     *   The date for which the report is generated.
     */
    public function sendSellerReport(Seller $seller, string $date): void;

    /**
     * Sends report data to all admins.
     *
     * @param string $date
     *   The date for which the report data is sent.
     */
    public function sendAdminReportData(string $date): void;
}
