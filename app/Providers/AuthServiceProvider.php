<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('manage-users', function($user){
            if($user->level == "admin")
            {
                return TRUE;
            }
        });
        Gate::define('manage-students', function($user){
            if($user->level == "admin")
            {
                return TRUE;
            }
        });
        Gate::define('manage-categories', function($user){
            if($user->level == "admin")
            {
                return TRUE;
            }
        });
        Gate::define('manage-courses', function($user){
            if($user->level == "admin")
            {
                return TRUE;
            }
        });
        Gate::define('manage-modules', function($user){
            if($user->level == "mentor")
            {
                return TRUE;
            }
        });
        //
    }
}
