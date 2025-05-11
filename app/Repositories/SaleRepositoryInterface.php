<?php

namespace App\Repositories;

use App\DTOs\SaleDataDto;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SaleRepositoryInterface
{
    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllSales(): Collection;

    /**
     * @param int $id
     *
     * @return Sale|null
     */
    public function getSaleById(int $id): ?Sale;

    /**
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerId(int $id): ?Collection;

    /**
     * @param int $id
     *
     * @param string $date
     *
     * @return Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerIdFromDate(int $id, string $date): ?Collection;

    /**
     * @param App\DTOs\SaleDataDto $data
     *
     * @return Sale
     */
    public function createSale(SaleDataDto $data): Sale;

    public function getAllSalesByDate(string $date): Collection;
    public function getUnreportedSalesByDate(string $date): Collection;
    public function markSalesAsReported(array $saleIds): void;
}
