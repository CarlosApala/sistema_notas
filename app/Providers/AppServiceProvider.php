<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;

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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('http');
        }
        Inertia::share([
            'auth' => function () {
                $user = auth()->user();


                return [
                    'user' => $user ? [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'permissions' => $user ? $user->permissions()->pluck('name') : [],
                    ] : null,
                ];
            },
        ]);
    }
}
