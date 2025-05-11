<?php

namespace App\Repositories;

use App\DTOs\SellerDataDto;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerRepository implements SellerRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllSellers(): Collection
    {
        return Seller::all();
    }

    /**
     * @inheritDoc
     */
    public function getSellerById(int $id): ?Seller
    {
        return Seller::find($id);
    }

    /**
     * @inheritDoc
     */
    public function createSeller(SellerDataDto $data): Seller
    {
        return Seller::create($data->toArray());
    }
}
