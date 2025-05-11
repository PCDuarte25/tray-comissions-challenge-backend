<?php

namespace App\Repositories;

use App\DTOs\SellerDataDto;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerRepository implements SellerRepositoryInterface
{

    public function getAllSellers(): Collection
    {
        return Seller::all();
    }

    /**
     * @param int $id
     *
     * @return Seller|null
     */
    public function getSellerById(int $id): ?Seller
    {
        return Seller::find($id);
    }

    /**
     * @param App\DTOs\SellerDataDto $data
     *
     * @return Seller
     */
    public function createSeller(SellerDataDto $data): Seller
    {
        return Seller::create($data->toArray());
    }
}
