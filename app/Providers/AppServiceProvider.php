<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The API has no Blade views, so the reset link must point to the Vue SPA.
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return sprintf(
                '%s/reset-password?token=%s&email=%s',
                config('app.frontend_url'),
                $token,
                urlencode($notifiable->getEmailForPasswordReset())
            );
        });
    }
}
