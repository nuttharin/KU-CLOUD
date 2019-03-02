<?php

namespace App\Providers;

use App\Repositories\Accounts\AccountsRepository;
use App\Repositories\Accounts\EloquentAccounts;
use App\Repositories\Address\AddressRepository;
use App\Repositories\Address\EloquentAddress;
use App\Repositories\TB_COMPANY\CompanyRepository;
use App\Repositories\TB_COMPANY\EloquentCompany;
use App\Repositories\TB_DASHBOARDS\DashboardsRepository;
use App\Repositories\TB_DASHBOARDS\EloquentDashboards;
use App\Repositories\TB_DASHBOARD_DATASOURCES\DatasourcesRepository;
use App\Repositories\TB_DASHBOARD_DATASOURCES\EloquentDatasources;
use App\Repositories\TB_DATA_ANALYSIS\DataAnalysisRepository;
use App\Repositories\TB_DATA_ANALYSIS\EloquentDataAnalysis;
use App\Repositories\TB_INFOGRAPHIC\EloquentInfographic;
use App\Repositories\TB_INFOGRAPHIC\InfographicRepository;
use App\Repositories\TB_REGISTER_IOT_SERVICE\EloquentRegisterIoTService;
use App\Repositories\TB_REGISTER_IOT_SERVICE\RegisterIoTServiceRepository;
use App\Repositories\TB_REGISTER_WEBSERVICE\EloquentRegisterWebservice;
use App\Repositories\TB_REGISTER_WEBSERVICE\RegisterWebserviceRepository;
use App\Repositories\TB_STATIC\EloquentStatic;
use App\Repositories\TB_STATIC\StaticRepository;
use App\Repositories\TB_USERS\EloquentUsers;
use App\Repositories\TB_USERS\UsersRepository;
use App\Repositories\TB_WEBSERVICE\EloquentWebService;
use App\Repositories\TB_WEBSERVICE\WebServiceRepository;
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

        $this->app->singleton(AddressRepository::class, EloquentAddress::class);
        $this->app->singleton(AccountsRepository::class, EloquentAccounts::class);
        $this->app->singleton(UsersRepository::class, EloquentUsers::class);
        $this->app->singleton(CompanyRepository::class, EloquentCompany::class);
        $this->app->singleton(WebServiceRepository::class, EloquentWebService::class);
        $this->app->singleton(RegisterWebserviceRepository::class, EloquentRegisterWebservice::class);
        $this->app->singleton(RegisterIoTServiceRepository::class, EloquentRegisterIoTService::class);
        $this->app->singleton(StaticRepository::class, EloquentStatic::class);
        $this->app->singleton(DataAnalysisRepository::class, EloquentDataAnalysis::class);
        $this->app->singleton(StaticRepository::class, EloquentStatic::class);
        $this->app->singleton(DashboardsRepository::class, EloquentDashboards::class);
        $this->app->singleton(DatasourcesRepository::class, EloquentDatasources::class);
        $this->app->singleton(InfographicRepository::class, EloquentInfographic::class);
    }

}
