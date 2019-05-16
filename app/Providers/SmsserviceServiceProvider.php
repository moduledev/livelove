<?php

namespace App\Providers;

use App\SmsService\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsserviceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('smsservice',function(){
            return new SmsService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
