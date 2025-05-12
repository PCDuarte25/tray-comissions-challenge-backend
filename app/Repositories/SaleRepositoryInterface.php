<?php

namespace App\Repositories;

use App\DTOs\SaleDataDto;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SaleRepositoryInterface
{
    /**
     * Get all sales.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSales(): Collection;

    /**
     * Get all sales paginated.
     *
     * @param int $pagLength
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllSalesPaginated(int $pagLength = 20): LengthAwarePaginator;

    /**
     * Get sale by ID.
     *
     * @param int $id
     *
     * @return \App\Models\Sale|null
     */
    public function getSaleById(int $id): ?Sale;

    /**
     * Get sales by seller ID.
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerId(int $id): ?Collection;

    /**
     * Get sales by seller ID from a specific date.
     *
     * @param int $id
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getSalesBySellerIdFromDate(int $id, string $date): ?Collection;

    /**
     * Create a new sale.
     *
     * @param App\DTOs\SaleDataDto $data
     *
     * @return \App\Models\Sale
     */
    public function createSale(SaleDataDto $data): Sale;

    /**
     * Get all sales by date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSalesByDate(string $date): Collection;

    /**
     * Get unreported sales by date.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreportedSalesByDate(string $date): Collection;

    /**
     * Mark sales as reported.
     *
     * @param array $saleIds
     */
    public function markSalesAsReported(array $saleIds): void;
}
