<?php

namespace App\Providers;

use App\Models\Permissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        foreach ($this->getAllPermissions() as $permission) {
            Gate::define($permission->nome, function($user) use($permission){
                return $user->containRole($permission->roles) || $user->isAdmin();
            });
        }
    }

    public function getAllPermissions()
    {
        return Permissions::with('roles')->get();
    }
}
