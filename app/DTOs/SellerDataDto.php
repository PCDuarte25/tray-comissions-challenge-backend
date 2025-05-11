<?php

namespace App\DTOs;

use App\Http\Requests\StoreSellerRequest;

class SellerDataDto
{
    public function __construct(
        public string $name,
        public string $email,
        public int $created_by_id
    ) {}

    public static function fromRequest(StoreSellerRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            name: $validated['name'],
            email: $validated['email'],
            created_by_id: $request->user()->id,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_by_id' => $this->created_by_id,
        ];
    }
}
