<?php

namespace App\Providers;

use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\CalendarRepositoryInterface;
use App\Interfaces\ChapterCardRepositoryInterface;
use App\Interfaces\ChapterRepositoryInterface;
use App\Interfaces\ColorRepositoryInterface;
use App\Interfaces\GroupRepositoryInterface;
use App\Interfaces\ManageRoleRepositoryInterface;
use App\Interfaces\ManageUserRepositoryInterface;
use App\Interfaces\OutlineRepositoryInterface;
use App\Interfaces\PlotPlannerRepositoryInterface;
use App\Interfaces\PremiseRepositoryInterface;
use App\Interfaces\SeriesRepositoryInterface;
use App\Interfaces\TimelineEventTypesRepositoryInterface;
use App\Interfaces\TimelineRepositoryInterface;
use App\Interfaces\UserGalleryRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\CalendarRepository;
use App\Repositories\ChapterCardRepository;
use App\Repositories\ChapterRepository;
use App\Repositories\ColorRepository;
use App\Repositories\GroupRepository;
use App\Repositories\ManageRoleRepository;
use App\Repositories\ManageUserRepository;
use App\Repositories\OutlineRepository;
use App\Repositories\PlotPlannerRepository;
use App\Repositories\PremiseRepository;
use App\Repositories\SeriesRepository;
use App\Repositories\TimelineEventTypesRepository;
use App\Repositories\TimelineRepository;
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
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(PremiseRepositoryInterface::class, PremiseRepository::class);
        $this->app->bind(OutlineRepositoryInterface::class, OutlineRepository::class);
        $this->app->bind(ChapterRepositoryInterface::class, ChapterRepository::class);
        $this->app->bind(ChapterCardRepositoryInterface::class, ChapterCardRepository::class);
        $this->app->bind(TimelineRepositoryInterface::class, TimelineRepository::class);
        $this->app->bind(TimelineEventTypesRepositoryInterface::class, TimelineEventTypesRepository::class);
        $this->app->bind(PlotPlannerRepositoryInterface::class, PlotPlannerRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
    }
}
