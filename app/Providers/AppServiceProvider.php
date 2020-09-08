<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DiveSite;
use App\Observers\DiveSiteObserver;

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
