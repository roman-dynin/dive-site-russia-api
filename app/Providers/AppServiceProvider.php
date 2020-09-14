<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\DiveSite;
use App\Models\Placemark;
use App\Observers\CourseObserver;
use App\Observers\DiveSiteObserver;
use App\Observers\PlacemarkObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        DiveSite::observe(DiveSiteObserver::class);

        Placemark::observe(PlacemarkObserver::class);

        Course::observe(CourseObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
