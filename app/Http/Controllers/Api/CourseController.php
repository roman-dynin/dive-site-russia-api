<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\User;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use Tochka\JsonRpc\Traits\JsonRpcController;

/**
 * Class CourseController.
 */
class CourseController
{
    use JsonRpcController;

    /**
     * Получение курсов.
     *
     * @return array
     */
    public function getCourses()
    {
        $courses = Course::query()
            ->with('locations')
            ->get();

        return [
            'courses' => $courses,
        ];
    }

    /**
     * Получение курса.
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function getCourseById()
    {
        $data = $this->validateAndFilter([
            'id' => [
                'numeric',
                'required',
                'exists:courses,id,deleted_at,NULL',
            ],
        ]);

        $course = Course::query()->find($data['id']);

        $course->load('locations');

        return [
            'course' => $course,
        ];
    }

    /**
     * Добавление курса.
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function addCourse()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

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
            'direction' => [
                'numeric',
                'required',
                'min:0',
                'max:360',
            ],
            'locations' => [
                'array',
                'required',
                'size:2',
            ],
            'locations.*' => [
                'array',
                'required',
            ],
            'locations.*.lat' => [
                'numeric',
                'required',
            ],
            'locations.*.lng' => [
                'numeric',
                'required',
            ],
        ]);

        $course = new Course();

        $course->user_id = $user->id;

        $course->fill($data);

        $course->save();

        $course->locations()->createMany($data['locations']);

        $course
            ->refresh()
            ->load('locations');

        return [
            'message' => 'Готово!',
            'course'  => $course,
        ];
    }

    /**
     * Редактирование курса.
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function updateCourseById()
    {
        if (! auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        $data = $this->validateAndFilter([
            'id' => [
                'required',
                'numeric',
                'exists:courses,id,deleted_at,NULL',
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
            'direction' => [
                'numeric',
                'required',
                'min:0',
                'max:360',
            ],
            'locations' => [
                'array',
                'required',
                'size:2',
            ],
            'locations.*' => [
                'array',
                'required',
            ],
            'locations.*.lat' => [
                'numeric',
                'required',
            ],
            'locations.*.lng' => [
                'numeric',
                'required',
            ],
        ]);

        /**
         * @var Course $course
         */
        $course = Course::query()->find($data['id']);

        $course->user_id = $user->id;

        $course->fill($data);

        $course->save();

        $course->locations()->delete();

        $course->locations()->createMany($data['locations']);

        $course
            ->refresh()
            ->load('locations');

        return [
            'message' => 'Готово!',
            'course'  => $course,
        ];
    }
}
