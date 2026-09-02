<?php

namespace App\Providers;

use App\Contracts\EventRepositoryInterface;
use App\Contracts\RobotRepositoryInterface;
use App\Eloquent\EventRepository;
use App\Eloquent\RobotRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
             $this->app->bind(EventRepositoryInterface::class, concrete: EventRepository::class);
             $this->app->bind(RobotRepositoryInterface::class, concrete: RobotRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
