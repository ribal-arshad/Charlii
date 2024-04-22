<?php

namespace App\Providers;

use App\Interfaces\ManageRoleRepositoryInterface;
use App\Interfaces\ManageUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ManageRoleRepository;
use App\Repositories\ManageUserRepository;
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
    }
}
