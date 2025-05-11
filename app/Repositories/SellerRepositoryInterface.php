<?php

namespace App\Repositories;

use App\DTOs\SellerDataDto;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

interface SellerRepositoryInterface
{
    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllSellers(): Collection;

    /**
     * @param int $id
     *
     * @return Seller|null
     */
    public function getSellerById(int $id): ?Seller;

    /**
     * @param App\DTOs\SellerDataDto $data
     *
     * @return Seller
     */
    public function createSeller(SellerDataDto $data): Seller;
}
