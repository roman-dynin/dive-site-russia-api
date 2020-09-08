<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DiveSite
 *
 * @package App\Models
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DiveSite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Местонахождение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function location()
    {
        return $this->morphOne(Location::class, 'target');
    }
}