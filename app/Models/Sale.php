<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Sale model.
 *
 * @property int $id
 * @property int $seller_id
 * @property int $created_by_id
 * @property float $value
 * @property float $commission
 * @property bool $reported
 * @property \Illuminate\Support\Carbon $sale_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\Seller $seller
 * @property-read \App\Models\User $createdBy
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
