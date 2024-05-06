<?php

namespace Dcblogdev\LaravelSentEmails;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Dcblogdev\LaravelSentEmails\Listeners\EmailLogger;

class SentEmailsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            MessageSending::class,
            EmailLogger::class
        );

        $this->loadViewsFrom(__DIR__.'/resources/views', 'sentemails');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/sentemails.php' => config_path('sentemails.php'),
            ], 'config');

            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/database/migrations/create_sent_emails_table.php' => $this->app->databasePath() . "/migrations/{$timestamp}_create_sent_emails_table.php",
            ], 'migrations');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/resources/views' => resource_path('views/vendor/sentemails'),
            ], 'views');

        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__. '/../config/sentemails.php', 'sentemails');
    }
}
