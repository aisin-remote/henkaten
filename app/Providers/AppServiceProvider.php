<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Henkaten;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.partials.header', function ($view) {

            $currentDate = Carbon::now()->format('Y-m-d');
            $empOrigin = auth()->user()->origin_id;
            
            // get all data from henaktens table that dont have troubleshoot
            $henkatens = Henkaten::with('line.origin')
                        ->with('shift')
                        ->whereHas('line', function ($query) use ($empOrigin){
                            $query->where('origin_id', $empOrigin);
                        })
                        ->where('is_done', '0')
                        ->take(5)
                        ->latest()
                        ->get();

            $view->with([
                'henkatens' => $henkatens,
                'newHenkatens' => count($henkatens->where('date', 'LIKE', '%' . $currentDate .'%')),
                'henkatenItems' => count($henkatens)
            ]);
        });
        
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
