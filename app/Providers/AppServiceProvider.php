<?php

namespace App\Providers;

use App\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \View::composer(['auth.register', 'users.create', 'users.edit'], function($view) {
            $states = \Cache::rememberForever('states', function(){
                return \App\State::all();
            });

            $view->with('states', $states);
        });

        \View::composer(['home'], function($view) {
            $view->with('commision', Transaction::current()->commision()->sum('amount'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
