<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The Configuration model.
 *
 * @property int $id
 *   The identifier for the configuration.
 * @property string $key
 *   The key for the configuration.
 * @property string $value
 *   The value for the configuration.
 * @property string|null $description
 *   The description for the configuration.
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
