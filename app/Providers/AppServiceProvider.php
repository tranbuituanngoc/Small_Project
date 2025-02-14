<?php

namespace App\Providers;

use App\Services\City\CityService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Services\User\UserService;
use App\Services\User\UserServiceImp;
use App\Services\Role\RoleService;
use App\Services\Role\RoleServiceImp;
use App\Services\Hotel\HotelService;
use App\Services\Hotel\HotelServiceImp;
use App\Services\City\CityServiceImp;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(UserService::class, UserServiceImp::class);
        $this->app->singleton(UserService::class, UserServiceImp::class);
        $this->app->singleton(RoleService::class, RoleServiceImp::class);
        $this->app->singleton(HotelService::class, HotelServiceImp::class);
        $this->app->singleton(CityService::class, CityServiceImp::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
