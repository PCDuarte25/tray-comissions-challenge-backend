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
     * @param App\DTOs\SaleDataDto $data
     *
     * @return Sale
     */
    public function createSale(SaleDataDto $data): Sale
    {
        return Sale::create($data->toArray());
    }
}
