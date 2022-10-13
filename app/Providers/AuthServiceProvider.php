<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //admin,member // user

        Gate::define('admin', function($user){
            if($user->role_id == 1){
                if($user->status == 0){
                    return true;
                }
                if($user->status == 1){
                    Auth::logout();  // xử lý logout
                    Session::flush();
                    return false;
                }
            }
            if($user->role_id == 0){
                return false;
            }

        });
        Gate::define('member', function($user){
            if($user->status == 0){
                return true;
            }
            if($user->status == 1){
                Auth::logout();  // xử lý logout
                Session::flush();
                return false;
            }
        });
    }
}
