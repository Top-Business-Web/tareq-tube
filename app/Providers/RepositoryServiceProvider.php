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
    AdminInterface,
    ConfigCountInterface,
    CouponInterface,
    MessageInterface,
    NotificationInterface,
    PackageUserInterface,
    SliderInterface
};
use App\Repository\{
    AdminRepository,
    AuthRepository,
    CityRepository,
    ConfigCountRepository,
    CouponRepository,
    InterestRepository,
    MessageRepository,
    NotificationRepository,
    UserRepository,
    PackageRepository,
    PackageUserRepository,
    SliderRepository
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
        $this->app->bind(PackageUserInterface::class,PackageUserRepository::class);
        $this->app->bind(CityInterface::class,CityRepository::class);
        $this->app->bind(InterestInterface::class,InterestRepository::class);
        $this->app->bind(ConfigCountInterface::class,ConfigCountRepository::class);
        $this->app->bind(SliderInterface::class,SliderRepository::class);
        $this->app->bind(MessageInterface::class,MessageRepository::class);
        $this->app->bind(NotificationInterface::class,NotificationRepository::class);
        $this->app->bind(CouponInterface::class,CouponRepository::class);
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
