<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * This class is responsible for sending the admin report email.
 */
class AdminReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instantiate a new mail instance.
     */
    public function __construct(
        private User $user,
        private float $totalValue,
        private string $date
    ) {}

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Relatório diário de vendas - ADMIN')
            ->view('emails.admin_report')
            ->with([
                'user' => $this->user,
                'totalValue' => $this->totalValue,
                'date' => $this->date,
            ]);
    }
}
