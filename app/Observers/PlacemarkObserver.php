<?php

namespace App\Observers;

use App\Models\Placemark;

/**
 * Class CourseObserver.
 */
class PlacemarkObserver
{
    /**
     * @param Placemark $course
     */
    public function deleting(Placemark $course)
    {
        $course->location()->delete();
    }
}
