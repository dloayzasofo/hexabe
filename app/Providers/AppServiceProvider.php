<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Auth; 

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
        //
        Schema::defaultStringLength(191);
        
        view()->composer('*', function ($view) {
            $notificationUnread = 0;
            if (auth()->check()) {
                $notificationUnread = Notification::whereNull('read_at')
                    ->where('user_id', Auth::user()->id)
                    ->count();
            }
            $view->with('blade_notification_count', $notificationUnread);
        });
    }
}
