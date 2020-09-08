<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{
    DiveSite,
    Point,
    Course
};
use App\Observers\{
    DiveSiteObserver,
    PointObserver,
    CourseObserver
};

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
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
