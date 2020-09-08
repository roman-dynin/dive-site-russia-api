<?php

namespace App\Observers;

use App\Models\DiveSite;

/**
 * Class DiveSiteObserver.
 */
class DiveSiteObserver
{
    /**
     * @param DiveSite $diveSite
     */
    public function deleting(DiveSite $diveSite)
    {
        $diveSite->location()->delete();

        foreach ($diveSite->courses as $course) {
            $course->delete();
        }

        foreach ($diveSite->points as $point) {
            $point->delete();
        }
    }
}
