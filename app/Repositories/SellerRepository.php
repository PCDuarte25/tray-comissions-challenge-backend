<?php

namespace App\Repositories;

use App\DTOs\SellerDataDto;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getAllSellersPaginated(int $pagLength = 20): LengthAwarePaginator
    {
        return Seller::paginate($pagLength);
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
