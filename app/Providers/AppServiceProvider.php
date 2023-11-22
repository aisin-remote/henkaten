<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('JP', function(User $user){
            return $user->role === 'JP';
        });

        Gate::define('LDR', function(User $user){
            return $user->role === 'LDR';
        });
        
        Gate::define('SPV', function(User $user){
            return $user->role === 'SPV';
        });

        Gate::define('MGR', function(User $user){
            return $user->role === 'MGR';
        });
    }
}
