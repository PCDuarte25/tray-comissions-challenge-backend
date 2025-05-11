<?php

namespace App\Services;

use App\Models\Seller;

interface ReportServiceInterface
{
    public function sendDailyReports(string $date): void;

    public function sendSellerReport(Seller $seller, string $date): void;

    public function sendAdminReportData(string $date): void;
}
