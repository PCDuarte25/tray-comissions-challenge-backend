<?php

namespace App\Jobs;

use App\Mail\SellerReportMail;
use App\Models\Seller;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSellerReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Seller $seller,
        private int $salesCount,
        private float $totalValue,
        private float $totalCommission,
        private string $date
    ) {}

    public function handle()
    {
        Mail::to($this->seller->email)->send(
            new SellerReportMail(
                $this->seller,
                $this->salesCount,
                $this->totalValue,
                $this->totalCommission,
                $this->date
            )
        );
    }
}
