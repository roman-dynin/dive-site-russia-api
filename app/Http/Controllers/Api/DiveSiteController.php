<?php

namespace App\Http\Controllers\Api;

use App\Models\DiveSite;
use App\Models\User;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use Tochka\JsonRpc\Traits\JsonRpcController;

/**
 * Class DiveSiteController.
 */
class DiveSiteController
{
    use JsonRpcController;

    /**
     * Получение мест.
     *
     * @return array
     */
    public function getDiveSites()
    {
        $diveSites = DiveSite::query()
            ->with('location')
            ->get();

        return [
            'diveSites' => $diveSites,
        ];
    }

    /**
     * Получение места.
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function getDiveSiteById()
    {
        $data = $this->validateAndFilter([
            'id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
            ],
        ]);

        $diveSite = DiveSite::query()->find($data['id']);

        $diveSite->load('location');

        return [
            'diveSite' => $diveSite,
        ];
    }

    /**
     * Добавление места погружения.
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function addDiveSite()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        $data = $this->validateAndFilter([
            'dive_site' => [
                'array',
                'required',
            ],
            'dive_site.title' => [
                'string',
                'required',
                'max:255',
            ],
            'dive_site.description' => [
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

        $diveSite->user_id = $user->id;

        $diveSite->fill($data['dive_site']);

        $diveSite->save();

        $diveSite->location()->create($data['location']);

        $diveSite
            ->refresh()
            ->load('location');

        return [
            'message'  => 'Готово!',
            'diveSite' => $diveSite,
        ];
    }

    /**
     * Редактирование места погружения.
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function updateDiveSiteById()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $data = $this->validateAndFilter([
            'dive_site' => [
                'array',
                'required',
            ],
            'dive_site.id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
            ],
            'dive_site.title' => [
                'string',
                'required',
                'max:255',
            ],
            'dive_site.description' => [
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
         * @var DiveSite $diveSite
         */
        $diveSite = DiveSite::query()->find($data['dive_site']['id']);

        $diveSite->fill($data['dive_site']);

        $diveSite->save();

        $diveSite->location()->update($data['location']);

        $diveSite
            ->refresh()
            ->load('location');

        return [
            'message'  => 'Готово!',
            'diveSite' => $diveSite,
        ];
    }

    /**
     * Удаление места погружения.
     *
     * @return array
     *
     * @throws JsonRpcException|InvalidParametersException|\Exception
     */
    public function deleteDiveSiteById()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        $data = $this->validateAndFilter([
            'dive_site' => [
                'array',
                'required',
            ],
            'dive_site.id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
            ],
        ]);

        /**
         * @var DiveSite $diveSite
         */
        $diveSite = DiveSite::query()->find($data['dive_site']['id']);

        $diveSite->delete();

        return [
            'message' => 'Готово!',
        ];
    }
}
