<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Repository\Api\User\UserRepository as UserApiRepository;

use App\Interfaces\{
    AuthInterface,
    CityInterface,
    InterestInterface,
    PackageInterface,
    UserInterface,
    AdminInterface
};
use App\Repository\{
    AdminRepository,
    AuthRepository,
    CityRepository,
    InterestRepository,
    UserRepository,
    PackageRepository
};



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // start Web classes and interfaces
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(AdminInterface::class,AdminRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(PackageInterface::class,PackageRepository::class);
        $this->app->bind(CityInterface::class,CityRepository::class);
        $this->app->bind(InterestInterface::class,InterestRepository::class);
        // ----------------------------------------------------------------


        // start Api classes and interfaces
        $this->app->bind(UserRepositoryInterface::class,UserApiRepository::class);
        // ----------------------------------------------------------------

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
