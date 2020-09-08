<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use App\Models\Point;

/**
 * Class PointController
 *
 * @package App\Http\Controllers\Api
 */
class PointController
{
    use JsonRpcController;

    /**
     * Получение точек
     *
     * @return array
     */
    public function getPoints()
    {
        $points = Point::query()
            ->with('location')
            ->get();

        return [
            'points' => $points,
        ];
    }

    /**
     * Добавление точки
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function addPoint()
    {
        if (!auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $data = $this->validateAndFilter([
            'point' => [
                'array',
                'required',
            ],
            'point.dive_site_id' => [
                'numeric',
                'required',
                'exists:dive_sites,id',
            ],
            'point.type' => [
                'numeric',
                'required',
                Rule::in([
                    Point::TYPE_MISC,
                    Point::TYPE_SHORE,
                    Point::TYPE_SUBMERGED_OBJECT,
                ]),
            ],
            'point.title' => [
                'string',
                'required',
                'max:255',
            ],
            'point.description' => [
                'string',
                'nullable',
            ],
            'location' => [
                'array',
                'required',
            ],
            'point.lat' => [
                'numeric',
                'required',
            ],
            'point.lng' => [
                'numeric',
                'required',
            ],
        ]);

        $point = new Point();

        $point->fill($data);

        $point->save();

        $point->location()->create($data['location']);

        $point
            ->refresh()
            ->load('location');

        return [
            'message' => 'Готово!',
            'point'   => $point,
        ];
    }
}
