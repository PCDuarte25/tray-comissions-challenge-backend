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

/**
 * This job is responsible for sending the seller report email.
 */
class SendSellerReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Instantiate a new job instance.
     */
    public function __construct(
        private Seller $seller,
        private int $salesCount,
        private float $totalValue,
        private float $totalCommission,
        private string $date
    ) {}

    /**
     * Execute the job.
     */
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
