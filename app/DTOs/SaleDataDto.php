<?php

namespace App\DTOs;

use App\Http\Requests\StoreSaleRequest;
use Carbon\Carbon;

class SaleDataDto
{
    /**
     * The commission percentage for the sale.
     *
     * @var float
     */
    const COMMISSION_PCT = 0.085;

    public function __construct(
        public int $seller_id,
        public int $created_by_id,
        public float $value,
        public \Carbon\Carbon $sale_date,
        public float $commission
    ) {}

    public static function fromRequest(StoreSaleRequest $request): self
    {
        $validated = $request->validated();
        $value = $validated['value'];
        // @todo mover pro controller
        $commission = floor($value * self::COMMISSION_PCT * 100) / 100;

        return new self(
            seller_id: $validated['seller_id'],
            created_by_id: $request->user()->id,
            value: $value,
            sale_date: Carbon::parse($validated['sale_date']),
            commission: $commission,
        );
    }

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
