<?php

namespace App\Providers;

use App\Services\ConfirmationServiceFactory;
use App\Services\ConfirmationServiceInterface;
use App\Services\EmailServiceInterface;
use App\Services\SmsServiceInterface;
use App\Services\TelegramServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(ConfirmationServiceFactory::class, function ($app) {
            return new ConfirmationServiceFactory(
                $app->make(EmailServiceInterface::class),
                $app->make(SmsServiceInterface::class),
                $app->make(TelegramServiceInterface::class)
            );
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
