<?php

namespace App\Providers;

use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_COMPANY\EloquentCompany;
use App\Repositories\TB_USERS\EloquentUsers;
use App\Repositories\TB_USERS\UsersRepository;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UsersRepository::class,EloquentUsers::class);
        $this->app->singleton(CompanyRepository::class,EloquentCompany::class);
    }

}
