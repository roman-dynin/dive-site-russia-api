<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Placemark.
 *
 *
 * @property int $user_id
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Placemark extends Model
{
    use SoftDeletes;

    /**
     * Разное.
     */
    public const TYPE_MISC = 0;

    /**
     * Берег.
     */
    public const TYPE_SHORE = 1;

    /**
     * Затопленный объект
     */
    public const TYPE_SUBMERGED_OBJECT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dive_site_id',
        'type',
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'      => 'integer',
        'dive_site_id' => 'integer',
        'type'         => 'integer',
        'created_at'   => 'datetime:Y-m-d H:i:s',
        'updated_at'   => 'datetime:Y-m-d H:i:s',
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
}
