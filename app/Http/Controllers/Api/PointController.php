<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Rule;
use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\{
    JsonRpcException,
    RPC\InvalidParametersException
};
use App\Models\{
    User,
    Point
};

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

        /**
         * @var User $user
         */
        $user = auth()->user();

        $data = $this->validateAndFilter([
            'point' => [
                'array',
                'required',
            ],
            'point.dive_site_id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
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
            'location.lat' => [
                'numeric',
                'required',
            ],
            'location.lng' => [
                'numeric',
                'required',
            ],
        ]);

        $point = new Point();

        $point->user_id = $user->id;

        $point->fill($data['point']);

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
