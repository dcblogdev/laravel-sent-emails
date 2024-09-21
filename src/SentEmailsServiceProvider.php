<?php

namespace Dcblogdev\LaravelSentEmails;

use Dcblogdev\LaravelSentEmails\Listeners\EmailLogger;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SentEmailsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            MessageSending::class,
            EmailLogger::class
        );

        $this->loadViewsFrom(__DIR__.'/resources/views', 'sentemails');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/sentemails.php' => config_path('sentemails.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/database/migrations/2020_07_16_222057_create_sent_emails_table.php' => $this->app->databasePath().'/migrations/2020_07_16_222057_create_sent_emails_table.php',
                __DIR__.'/database/migrations/2024_05_07_222057_create_sent_emails_attachments_table.php' => $this->app->databasePath().'/migrations/2024_05_07_222057_create_sent_emails_attachments_table.php',
            ], 'migrations');

            $this->publishes([
                __DIR__.'/resources/views' => resource_path('views/vendor/sentemails'),
            ], 'views');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sentemails.php', 'sentemails');
    }
}
