<?php

namespace App\Jobs;

use App\Mail\AdminReportMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user,
        private float $totalValue,
        private string $date
    ) {}

    public function handle()
    {
        Mail::to($this->user->email)->send(
            new AdminReportMail(
                $this->user,
                $this->totalValue,
                $this->date
            )
        );
    }
}
