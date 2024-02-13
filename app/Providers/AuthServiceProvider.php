<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        User::class => StudentPolicy::class,   

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::before(function ($user) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });
    }
}
