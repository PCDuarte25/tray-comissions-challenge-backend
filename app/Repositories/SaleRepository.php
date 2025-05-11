<?php

namespace App\Repositories;

use App\DTOs\SaleDataDto;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository implements SaleRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllSales(): Collection
    {
        return Sale::all();
    }

    /**
     * @inheritDoc
     */
    public function getSaleById(int $id): ?Sale
    {
        return Sale::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getSalesBySellerId(int $id): ?Collection
    {
        return Sale::where('seller_id', $id)->get();
    }

    /**
     * @inheritDoc
     */
    public function getSalesBySellerIdFromDate(int $id, string $date): ?Collection
    {
        return Sale::where('seller_id', $id)->whereDate('sale_date', $date)->get();
    }

    /**
     * @inheritDoc
     */
    public function createSale(SaleDataDto $data): Sale
    {
        return Sale::create($data->toArray());
    }

    /**
     * @inheritDoc
     */
    public function getAllSalesByDate(string $date): Collection
    {
        return Sale::whereDate('sale_date', $date)->get();
    }

    /**
     * @inheritDoc
     */
    public function getUnreportedSalesByDate(string $date): Collection
    {
        return Sale::whereDate('sale_date', $date)
            ->where('reported', false)
            ->with('seller')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function markSalesAsReported(array $saleIds): void
    {
        Sale::whereIn('id', $saleIds)->update(['reported' => true]);
    }
}
