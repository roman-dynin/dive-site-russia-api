<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @package App\Models
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dive_site_id',
        'title',
        'description',
        'direction',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'dive_site_id' => 'integer',
        'direction'    => 'integer',
        'created_at'   => 'datetime:Y-m-d H:i:s',
        'updated_at'   => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Местонахождение
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class, 'target');
    }
}
