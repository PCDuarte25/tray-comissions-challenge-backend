<?php

namespace App\DTOs;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Configuration;
use Carbon\Carbon;

/**
 * SaleDataDto is a Data Transfer Object that encapsulates the data related to a sale.
 *
 * @property int $seller_id
 *   The ID of the seller associated with the sale.
 * @property int $created_by_id
 *   The ID of the user who created the sale.
 * @property float $value
 *   The value of the sale.
 * @property \Carbon\Carbon $sale_date
 *   The date of the sale.
 * @property float $commission
 *   The commission calculated based on the sale value.
 */
class SaleDataDto
{
    /**
     * SaleDataDto constructor.
     */
    public function __construct(
        public int $seller_id,
        public int $created_by_id,
        public float $value,
        public \Carbon\Carbon $sale_date,
        public float $commission
    ) {}

    /**
     * Create a new instance of SaleDataDto from a StoreSaleRequest and commission configuration.
     *
     * @param \App\Http\Requests\StoreSaleRequest $request
     *   The request containing the sale data.
     * @param \App\Models\Configuration $commissionConfig
     *   The commission configuration.
     *
     * @return \App\DTOs\SaleDataDto
     *   A new instance of SaleDataDto.
     */
    public static function fromRequest(StoreSaleRequest $request, Configuration $commissionConfig): self
    {
        $validated = $request->validated();
        $value = $validated['value'];
        // Ensure the value is a float.
        $commission = floor($value * $commissionConfig->value * 100) / 100;

        return new self(
            seller_id: $validated['seller_id'],
            created_by_id: $request->user()->id,
            value: $value,
            sale_date: Carbon::parse($validated['sale_date']),
            commission: $commission,
        );
    }

    /**
     * Convert the SaleDataDto instance to an array.
     *
     * @return array<string, mixed>
     *   An associative array representation of the SaleDataDto instance.
     */
    public function toArray(): array
    {
        return [
            'seller_id' => $this->seller_id,
            'created_by_id' => $this->created_by_id,
            'value' => $this->value,
            'sale_date' => $this->sale_date,
            'commission' => $this->commission,
        ];
    }
}
