<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmergedObject extends Model
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
     * Точка
     */
    public function point()
    {
        return $this->morphOne(Point::class, 'target');
    }
}
