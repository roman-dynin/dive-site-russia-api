<?php

namespace App\Observers;

use App\Models\Point;

/**
 * Class CourseObserver.
 */
class PointObserver
{
    /**
     * @param Point $course
     */
    public function deleting(Point $course)
    {
        $course->location()->delete();
    }
}
