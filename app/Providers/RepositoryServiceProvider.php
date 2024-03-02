<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Interfaces\Api\User\PaymentRepositoryInterface;
use App\Repository\Api\User\UserRepository as UserApiRepository;
use App\Repository\Api\User\PaymentRepository as PaymentApiRepository;

use App\Interfaces\{AuthInterface,
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
    SliderInterface,
    UserActionInterface,
    TubeInterface,
    ModelPriceInterface,
    PaymentTransactionInterface,
    SettingInterface,
    WithdrawInterface, YoutubeKeyInterface};
use App\Repository\{AdminRepository,
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
    SliderRepository,
    UserActionRepository,
    TubeRepository,
    ModelPriceRepository,
    SettingRepository,
    PaymentTransactionRepository,
    WithdrawRepository, YoutubeKeyRepository};



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
        $this->app->bind(UserActionInterface::class,UserActionRepository::class);
        $this->app->bind(TubeInterface::class,TubeRepository::class);
        $this->app->bind(ModelPriceInterface::class,ModelPriceRepository::class);
        $this->app->bind(SettingInterface::class,SettingRepository::class);
        $this->app->bind(WithdrawInterface::class,WithdrawRepository::class);
        $this->app->bind(PaymentTransactionInterface::class,PaymentTransactionRepository::class);
        $this->app->bind(YoutubeKeyInterface::class,YoutubeKeyRepository::class);
        // ----------------------------------------------------------------


        // start Api classes and interfaces
        $this->app->bind(UserRepositoryInterface::class,UserApiRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class,PaymentApiRepository::class);
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
