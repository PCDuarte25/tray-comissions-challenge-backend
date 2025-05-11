<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The Configuration model.
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Configuration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}
