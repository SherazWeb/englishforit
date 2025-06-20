<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('module', function ($value) {
            return Module::where('slug', $value)->firstOrFail();
        });

        Route::bind('lesson', function ($value) {
            return Lesson::where('slug', $value)->firstOrFail();
        });

        Model::unguard();
    }
}
