<?php

namespace App\Observers;

use App\Models\Course;

/**
 * Class CourseObserver.
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
