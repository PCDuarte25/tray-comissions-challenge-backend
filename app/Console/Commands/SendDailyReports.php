<?php

namespace App\Console\Commands;

use App\Services\ReportService;
use Illuminate\Console\Command;

/**
 * Class SendDailyReports
 *
 * @package App\Console\Commands
 */
class SendDailyReports extends Command
{
    protected $signature = 'app:send-daily-reports';

    protected $description = 'Send daily sales reports';

    /**
     * Creates a new instance of the SendDailyReports.
     */
    public function __construct(private ReportService $reportService) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $date = now()->toDateString();

        $this->reportService->sendDailyReports($date);
        $this->info('Daily reports sent successfully.');
        $this->reportService->sendAdminReportData($date);
        $this->info('Admin report data sent successfully.');

        $this->info('Reports sent successfully.');
    }
}
