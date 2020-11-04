<?php

namespace App\Observers;

use App\Models\Placemark;

/**
 * Class PlacemarkObserver.
 */
class PlacemarkObserver
{
    /**
     * @param Placemark $placemark
     */
    public function deleting(Placemark $placemark)
    {
        $placemark->location()->delete();
    }
}
