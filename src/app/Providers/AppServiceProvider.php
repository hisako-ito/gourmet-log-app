<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Area;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('layouts.navigation', function ($view) {
            $view->with('areas', Area::all());
            $view->with('categories', Category::all());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}
}
