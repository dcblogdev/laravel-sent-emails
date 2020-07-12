<?php

namespace Dcblogdev\LaravelSentEmails;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Dcblogdev\LaravelSentEmails\Listeners\EmailLogger;
use Illuminate\Support\Facades\Event;

class SentEmailsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            MessageSending::class,
            EmailLogger::class
        );

        $this->loadViewsFrom(__DIR__.'/resources/views', 'sentemails');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

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

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__. '/../config/sentemails.php', 'sentemails');

        // Register the main class to use with the facade
        $this->app->singleton('sent-emails', function () {
            return new SentEmails;
        });
    }
}
