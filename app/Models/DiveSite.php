<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DiveSite.
 *
 *
 * @property int $user_id
 * @property Course[] $courses
 * @property Placemark[] $placemarks
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DiveSite extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'    => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Местонахождение.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function location()
    {
        return $this->morphOne(Location::class, 'target');
    }

    /**
     * Курсы.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Метки.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function placemarks()
    {
        return $this->hasMany(Placemark::class);
    }
}
