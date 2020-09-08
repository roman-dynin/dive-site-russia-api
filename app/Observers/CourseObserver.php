<?php

namespace App\Observers;

use App\Models\Course;

/**
 * Class CourseObserver
 *
 * @package App\Observers
 */
class CourseObserver
{
    /**
     * @param Course $course
     */
    public function deleting(Course $course)
    {
        $course->locations()->delete();
    }
}
