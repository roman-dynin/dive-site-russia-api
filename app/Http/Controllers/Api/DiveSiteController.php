<?php

namespace App\Http\Controllers\Api;

use App\Models\DiveSite;
use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;

class DiveSiteController
{
    use JsonRpcController;

    /**
     * Получение мест
     *
     * @return array
     *
     * @throws JsonRpcException
     */
    public function getDiveSites()
    {
        if (!auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $diveSites = DiveSite::query()
            ->with('point')
            ->get();

        return [
            'diveSites' => $diveSites,
        ];
    }

    /**
     * Добавление места
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function addDiveSite()
    {
        $data = $this->validateAndFilter([
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

        $diveSite = new DiveSite();

        $diveSite->fill($data);

        $diveSite->save();

        $diveSite->point()->create([
            'location' => [
                $data['location']['lat'],
                $data['location']['lng'],
            ]
        ]);

        $diveSite->refresh();

        $diveSite->load('point');

        return [
            'diveSite' => $diveSite,
        ];
    }

    /**
     * Редактирование места
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function updateDiveSiteById()
    {
        $data = $this->validateAndFilter([
            'id' => [
                'numeric',
                'required',
                'exists:dive_sites',
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
                'size:2',
            ],
            'location.*' => [
                'numeric',
                'required',
            ],
        ]);

        $diveSite = DiveSite::find($data['id']);

        $diveSite->fill($data);

        $diveSite->save();

        $diveSite->point->fill($data);

        $diveSite->point->save();

        return [
            'message' => 'Готово!',
        ];
    }

    /**
     * Удаление места
     *
     * @return array
     *
     * @throws InvalidParametersException|\Exception
     */
    public function deleteDiveSiteById()
    {
        $data = $this->validateAndFilter([
            'id' => [
                'numeric',
                'required',
                'exists:dive_sites',
            ],
        ]);

        $diveSite = DiveSite::find($data['id']);

        $diveSite->delete();

        return [
            'message' => 'Готово!',
        ];
    }
}
