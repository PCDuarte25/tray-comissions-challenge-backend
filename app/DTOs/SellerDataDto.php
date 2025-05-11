<?php

namespace App\DTOs;

use App\Http\Requests\StoreSellerRequest;

/**
 * SellerDataDto is a Data Transfer Object that encapsulates the data related to a seller.
 *
 * @property string $name
 *  The name of the seller.
 * @property string $email
 *  The email of the seller.
 * @property int $created_by_id
 *  The ID of the user who created the seller.
 */
class SellerDataDto
{
    /**
     * SellerDataDto constructor.
     */
    public function __construct(
        public string $name,
        public string $email,
        public int $created_by_id
    ) {}

    /**
     * Create a new instance of SellerDataDto from a StoreSellerRequest.
     *
     * @param \App\Http\Requests\StoreSellerRequest $request
     *   The request containing the seller data.
     *
     * @return \App\DTOs\SellerDataDto
     *   A new instance of SellerDataDto.
     */
    public static function fromRequest(StoreSellerRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            name: $validated['name'],
            email: $validated['email'],
            created_by_id: $request->user()->id,
        );
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     *   An associative array representation of the DTO.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_by_id' => $this->created_by_id,
        ];
    }
}
