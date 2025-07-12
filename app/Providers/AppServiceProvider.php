<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('mail', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
        }, '有効なメールアドレスを入力してください。');
    }
    }
