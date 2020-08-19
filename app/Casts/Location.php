<?php

namespace App\Casts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Location implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        $value = str_replace(['(', ')'], ['', ''], $value);

        $value = explode(',', $value);

        $value = array_map(function ($value) {
            return (float) $value;
        }, $value);

        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return implode(',', $value);
    }
}
