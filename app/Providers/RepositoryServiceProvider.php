<?php

namespace App\Providers;

use App\Interfaces\CalendarRepositoryInterface;
use App\Interfaces\ColorRepositoryInterface;
use App\Interfaces\ManageRoleRepositoryInterface;
use App\Interfaces\ManageUserRepositoryInterface;
use App\Interfaces\SeriesRepositoryInterface;
use App\Interfaces\UserGalleryRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CalendarRepository;
use App\Repositories\ColorRepository;
use App\Repositories\ManageRoleRepository;
use App\Repositories\ManageUserRepository;
use App\Repositories\SeriesRepository;
use App\Repositories\UserGalleryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ManageUserRepositoryInterface::class, ManageUserRepository::class);
        $this->app->bind(ManageRoleRepositoryInterface::class, ManageRoleRepository::class);
        $this->app->bind(UserGalleryRepositoryInterface::class, UserGalleryRepository::class);
        $this->app->bind(ColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(CalendarRepositoryInterface::class, CalendarRepository::class);
        $this->app->bind(SeriesRepositoryInterface::class, SeriesRepository::class);
    }
}
