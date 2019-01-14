<?php

namespace App\Providers;

use App\Repositories\Accounts\AccountsRepository;
use App\Repositories\Accounts\EloquentAccounts;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_COMPANY\EloquentCompany;
use App\Repositories\TB_STATIC\EloquentStatic;
use App\Repositories\TB_STATIC\StaticRepository;
use App\Repositories\TB_USERS\EloquentUsers;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_WEBSERVICE\EloquentWebService;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
use App\Repositories\TB_INFOGRAPHIC\EloquentInfographic;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;
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
        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('th_TH');
          });
        $this->app->singleton(AccountsRepository::class,EloquentAccounts::class);
        $this->app->singleton(UsersRepository::class,EloquentUsers::class);
        $this->app->singleton(CompanyRepository::class,EloquentCompany::class);
        $this->app->singleton(WebServiceRepository::class,EloquentWebService::class);
        $this->app->singleton(StaticRepository::class,EloquentStatic::class);
        $this->app->singleton(InfographicRepository::class,EloquentInfographic::class);
    }

}
