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
     * Получение меток.
     *
     * @return array
     */
    public function getPlacemarks()
    {
        $placemarks = Placemark::query()
            ->with([
                'user',
                'location',
            ])
            ->get();

        return [
            'placemarks' => $placemarks,
        ];
    }

    /**
     * Получение метки.
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

        $placemark->load([
            'user',
            'location',
        ]);

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
            'type' => [
                'numeric',
                'required',
                Rule::in([
                    Placemark::TYPE_MISC,
                    Placemark::TYPE_DIVE_CLUB,
                    Placemark::TYPE_DIVE_SITE,
                    Placemark::TYPE_SHORE,
                    Placemark::TYPE_SUBMERGED_OBJECT,
                ]),
            ],
            'title' => [
                'string',
                'required',
                'max:255',
            ],
            'description' => [
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

        $placemark->fill($data);

        $placemark->save();

        $placemark->location()->create($data['location']);

        $placemark
            ->refresh()
            ->load([
                'user',
                'location',
            ]);

        return [
            'placemark' => $placemark,
        ];
    }

    /**
     * Редактирование метки.
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function updatePlacemarkById()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $data = $this->validateAndFilter([
            'id' => [
                'required',
                'numeric',
                'exists:placemarks,id,deleted_at,NULL',
            ],
            'type' => [
                'numeric',
                'required',
                Rule::in([
                    Placemark::TYPE_MISC,
                    Placemark::TYPE_DIVE_CLUB,
                    Placemark::TYPE_DIVE_SITE,
                    Placemark::TYPE_SHORE,
                    Placemark::TYPE_SUBMERGED_OBJECT,
                ]),
            ],
            'title' => [
                'string',
                'required',
                'max:255',
            ],
            'description' => [
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

        /**
         * @var Placemark $placemark
         */
        $placemark = Placemark::query()->find($data['id']);

        $placemark->fill($data);

        $placemark->save();

        $placemark->location()->update($data['location']);

        $placemark
            ->refresh()
            ->load([
                'user',
                'location',
            ]);

        return [
            'placemark' => $placemark,
        ];
    }

    /**
     * Удаление метки.
     *
     * @throws JsonRpcException
     */
    public function deletePlacemarkById()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $data = $this->validateAndFilter([
            'id' => [
                'required',
                'numeric',
                'exists:placemarks,id,deleted_at,NULL',
            ],
        ]);

        /**
         * @var Placemark $placemark
         */
        $placemark = Placemark::query()->find($data['id']);

        $placemark->delete();

        return [];
    }
}
