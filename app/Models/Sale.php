<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Sale model.
 *
 * @property int $id
 *   The identifier for the sale.
 * @property int $seller_id
 *   The ID from the seller who made the sale.
 * @property \App\Models\Seller $seller
 *   The seller who made the sale.
 * @property float $value
 *   The value of the sale.
 * @property \Illuminate\Support\Carbon $sale_date
 *   The date of the sale.
 * @property int $created_by_id
 *   The ID from the user who created the sale.
 * @property \App\Models\User $created_by
 *   The user who created the sale.
 * @property \Illuminate\Support\Carbon $created_at
 *   The date and time the sale was created.
 * @property float $commission
 *   The commission from the sale.
 * @property bool $reported
 *   Whether the sale was reported or not by e-mail.
 */
class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'seller_id',
        'created_by_id',
        'value',
        'sale_date',
        'commission',
    ];

    /**
     * Get the user that created the sale.
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the seller that made the sale.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
