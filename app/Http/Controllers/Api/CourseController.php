<?php

namespace App\Http\Controllers\Api;

use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\{
    JsonRpcException,
    RPC\InvalidParametersException
};
use App\Models\{
    User,
    Course
};

/**
 * Class CourseController
 *
 * @package App\Http\Controllers\Api
 */
class CourseController
{
    use JsonRpcController;

    /**
     * Получение курсов
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
     * Добавление курса
     *
     * @throws JsonRpcException|InvalidParametersException
     */
    public function addCourse()
    {
        if (!auth()->check()) {
            throw new JsonRpcException(JsonRpcException::CODE_UNAUTHORIZED);
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        $data = $this->validateAndFilter([
            'course' => [
                'array',
                'required',
            ],
            'course.dive_site_id' => [
                'numeric',
                'required',
                'exists:dive_sites,id,deleted_at,NULL',
            ],
            'course.title' => [
                'string',
                'required',
                'max:255',
            ],
            'course.description' => [
                'string',
                'nullable',
            ],
            'course.direction' => [
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

        $course->fill($data['course']);

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
}
