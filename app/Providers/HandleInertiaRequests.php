<?php
// app/Providers/HandleInertiaRequests.php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

class HandleInertiaRequests extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Udostępnij dane do wszystkich komponentów Inertia
        Inertia::share([
            'app' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
            ],
            'auth' => function (Request $request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        // dodaj inne pola użytkownika
                    ] : null,
                ];
            },
            'flash' => function (Request $request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                    'warning' => $request->session()->get('warning'),
                    'info' => $request->session()->get('info'),
                ];
            },
        ]);
    }
}
