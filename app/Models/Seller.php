<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The Seller model.
 *
 * @property int $id
 *   The identifier for the seller.
 * @property string $name
 *   The name of the seller.
 * @property string $email
 *   The email address of the seller.
 * @property int $created_by_id
 *   The ID from the user who created the seller.
 * @property \App\Models\User $created_by
 *   The user who created the seller.
 * @property \Illuminate\Support\Carbon $created_at
 *   The date and time the seller was created.
 */
class Seller extends Model
{
    /** @use HasFactory<\Database\Factories\SellerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Get the user that created the seller.
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sales for the seller.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
