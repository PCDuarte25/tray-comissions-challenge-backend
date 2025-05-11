<?php

namespace App\Repositories;

use App\DTOs\SaleDataDto;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllSales(): Collection
    {
        return Sale::all();
    }

    /**
     * @param int $id
     *
     * @return Sale|null
     */
    public function getSaleById(int $id): ?Sale
    {
        return Sale::find($id);
    }

    /**
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerId(int $id): ?Collection
    {
        return Sale::where('seller_id', $id)->get();
    }

    /**
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerIdFromDate(int $id, string $date): ?Collection
    {
        return Sale::where('seller_id', $id)->whereDate('sale_date', $date)->get();
    }

    /**
     * @param App\DTOs\SaleDataDto $data
     *
     * @return Sale
     */
    public function createSale(SaleDataDto $data): Sale
    {
        return Sale::create($data->toArray());
    }

    public function getAllSalesByDate(string $date): Collection
    {
        return Sale::whereDate('sale_date', $date)->get();
    }

    public function getUnreportedSalesByDate(string $date): Collection
    {
        return Sale::whereDate('sale_date', $date)
            ->where('reported', false)
            ->with('seller')
            ->get();
    }

    public function markSalesAsReported(array $saleIds): void
    {
        Sale::whereIn('id', $saleIds)->update(['reported' => true]);
    }
}
