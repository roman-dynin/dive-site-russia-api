<?php

namespace App\Http\Controllers\Api;

use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use App\Models\SubmergedObject;

class SubmergedObjectController
{
    use JsonRpcController;

    public function getSubmergedObjects()
    {
        $submergedObjects = SubmergedObject::with('point')->get();

        return [
            'submergedObjects' => $submergedObjects,
        ];
    }

    /**
     * @return SubmergedObject[]
     *
     * @throws InvalidParametersException
     */
    public function addSubmergedObject()
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
            'point' => [
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

        $submergedObject = new SubmergedObject();

        $submergedObject->fill($data);

        $submergedObject->save();

        $submergedObject->point()->create([
            'location' => [
                $data['point']['lat'],
                $data['point']['lng'],
            ]
        ]);

        $submergedObject->refresh();

        $submergedObject->load('point');

        return [
            'submergedObject' => $submergedObject,
        ];
    }
}
