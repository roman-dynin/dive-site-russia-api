<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\DiveSite;
use App\Models\Point;
use App\Observers\CourseObserver;
use App\Observers\DiveSiteObserver;
use App\Observers\PointObserver;
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

        Point::observe(PointObserver::class);

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
