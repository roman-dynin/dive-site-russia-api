<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @package App\Models
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_type',
        'target_id',
        'lat',
        'lng',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'target_id'  => 'integer',
        'lat'        => 'decimal:7',
        'lng'        => 'decimal:7',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
