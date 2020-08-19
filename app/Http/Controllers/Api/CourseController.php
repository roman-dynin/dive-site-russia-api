<?php

namespace App\Http\Controllers\Api;

use Tochka\JsonRpc\Traits\JsonRpcController;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use App\Models\Course;

class CourseController
{
    use JsonRpcController;

    /**
     * @return array
     */
    public function getCourses()
    {
        $courses = Course::with('points')->get();

        return [
            'courses' => $courses,
        ];
    }

    /**
     * @throws InvalidParametersException
     */
    public function addCourse()
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
            'direction' => [
                'numeric',
                'required',
                'min:0',
                'max:360',
            ],
            'points' => [
                'array',
                'required',
                'size:2',
            ],
            'points.*' => [
                'array',
                'required',
            ],
            'points.*.lat' => [
                'numeric',
                'required',
            ],
            'points.*.lng' => [
                'numeric',
                'required',
            ],
        ]);

        $course = new Course();

        $course->fill($data);

        $course->save();

        $points = array_map(function ($point) {
            return [
                'location' => [
                    $point['lat'],
                    $point['lng'],
                ],
            ];
        }, $data['points']);

        $course->points()->createMany($points);

        $course->refresh();

        $course->load('points');

        return [
            'course' => $course,
        ];
    }

    public function updateCourseById()
    {

    }

    public function deleteCourseById()
    {

    }
}
