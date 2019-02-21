<?php

namespace App\Providers;

use Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('isAdmin', function ($user) {
            return $user->type_user == 'ADMIN';
        });

        $gate->define('isCompanyAdmin', function ($user) {
            $type = $user->type_user;
            $user = $user->user_company()->get()->first();
            if (!empty($user)) {
                if ($type == 'COMPANY') {
                    return $user->sub_type_user == 'ADMIN';
                }
            }
        });

        $gate->define('isCompanyNormal', function ($user) {
            $user = $user->user_company()->get()->first();
            return $user->sub_type_user == 'NORMAL';
        });

        $gate->define('isCustomer', function ($user) {
            return $user->type_user == 'CUSTOMER';
        });

        //
    }
}
