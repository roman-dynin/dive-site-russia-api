<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Placemark.
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
     * Дайвинг-клуб.
     */
    public const TYPE_DIVE_CLUB = 1;

    /**
     * Место погружения.
     */
    public const TYPE_DIVE_SITE = 2;

    /**
     * Берег.
     */
    public const TYPE_SHORE = 3;

    /**
     * Затопленный объект.
     */
    public const TYPE_SUBMERGED_OBJECT = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
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
        'user_id'    => 'integer',
        'type'       => 'integer',
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
