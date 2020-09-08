<?php

namespace App\Observers;

use App\Models\Point;

/**
 * Class CourseObserver
 *
 * @package App\Observers
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
