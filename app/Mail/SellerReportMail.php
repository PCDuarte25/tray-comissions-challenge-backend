<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Mail\Mailable;

/**
 * This class is responsible for sending the seller report email.
 */
class SellerReportMail extends Mailable
{
    /**
     * Instantiate a new mail instance.
     */
    public function __construct(
        private Seller $seller,
        private int $salesCount,
        private float $totalValue,
        private float $totalCommission,
        private string $date
    ) {}

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Relatório diário de vendas')
            ->view('emails.seller_report')
            ->with([
                'seller' => $this->seller,
                'salesCount' => $this->salesCount,
                'totalValue' => $this->totalValue,
                'totalCommission' => $this->totalCommission,
                'date' => $this->date,
            ]);
    }
}
