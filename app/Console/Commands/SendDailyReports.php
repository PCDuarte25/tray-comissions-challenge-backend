<?php

namespace App\Console\Commands;

use App\Jobs\SendAdminReportJob;
use App\Jobs\SendSellerReportJob;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Console\Command;

class SendDailyReports extends Command
{
    protected $signature = 'app:send-daily-reports';

    protected $description = 'Send daily sales reports';

    public function handle(): void
    {
        $date = now()->toDateString();

        $this->sendSellerDailyReport($date);

        $this->sendAdminDailyReport($date);

        $this->info('Reports sent successfully.');
    }

    protected function sendSellerDailyReport(string $date) {
        $sales = Sale::whereDate('sale_date', $date)
            ->where('reported', false)
            ->with('seller')
            ->get();

        $sales->groupBy('seller_id')->each(function ($group) use ($date) {
            $seller = $group->first()->seller;

            SendSellerReportJob::dispatch(
                $seller,
                $group->count(),
                $group->sum('value'),
                $group->sum('commission'),
                $date
            );
        });

        Sale::whereIn('id', $sales->pluck('id'))->update(['reported' => true]);
    }

    protected function sendAdminDailyReport(string $date) {
        $sales = Sale::whereDate('sale_date', $date)->get();

        User::all()->each(function ($user) use ($sales, $date) {
            SendAdminReportJob::dispatch(
                $user,
                $sales->sum('value'),
                $date
            );
        });
    }
}
