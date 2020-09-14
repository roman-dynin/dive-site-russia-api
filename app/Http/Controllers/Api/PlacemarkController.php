<?php

namespace App\Http\Controllers\Api;

use App\Models\Placemark;
use App\Models\User;
use Illuminate\Validation\Rule;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use Tochka\JsonRpc\Traits\JsonRpcController;

/**
 * Class PlacemarkController.
 */
class PlacemarkController
{
    use JsonRpcController;

    /**
     * Получение точек.
     *
     * @return array
     */
    public function getPlacemarks()
    {
        $placemarks = Placemark::query()
            ->with('location')
            ->get();

        return [
            'placemarks' => $placemarks,
        ];
    }

    /**
     * Получение точки.
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function getPlacemarkById()
    {
        $data = $this->validateAndFilter([
            'id' => [
                'numeric',
                'required',
                'exists:placemarks,id,deleted_at,NULL',
            ],
        ]);

        $placemark = Placemark::query()->find($data['id']);

        $placemark->load('location');

        return [
            'placemark' => $placemark,
        ];
    }

    /**
     * Добавление метки.
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function addPlacemark()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        $data = $this->validateAndFilter([
            'placemark' => [
                'array',
                'required',
            ],
            'placemark.dive_site_id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
            ],
            'placemark.type' => [
                'numeric',
                'required',
                Rule::in([
                    Placemark::TYPE_MISC,
                    Placemark::TYPE_SHORE,
                    Placemark::TYPE_SUBMERGED_OBJECT,
                ]),
            ],
            'placemark.title' => [
                'string',
                'required',
                'max:255',
            ],
            'placemark.description' => [
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

        $placemark = new Placemark();

        $placemark->user_id = $user->id;

        $placemark->fill($data['placemark']);

        $placemark->save();

        $placemark->location()->create($data['location']);

        $placemark
            ->refresh()
            ->load('location');

        return [
            'message'   => 'Готово!',
            'placemark' => $placemark,
        ];
    }
}
