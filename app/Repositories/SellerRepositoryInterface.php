<?php

namespace App\Repositories;

use App\DTOs\SellerDataDto;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

interface SellerRepositoryInterface
{
    /**
     * Get all sellers.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllSellers(): Collection;

    /**
     * Get seller by ID.
     *
     * @param int $id
     *
     * @return \App\Models\Seller|null
     */
    public function getSellerById(int $id): ?Seller;

    /**
     * Create a new seller.
     *
     * @param App\DTOs\SellerDataDto $data
     *
     * @return \App\Models\Seller
     */
    public function createSeller(SellerDataDto $data): Seller;
}
