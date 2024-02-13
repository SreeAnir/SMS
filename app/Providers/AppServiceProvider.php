<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Validator::extend('parent_required_if_minor', function ($attribute, $value, $parameters, $validator) {
            $dob = $validator->getData()[$parameters[0]]; // $parameters[0] should contain the date of birth field name
            $today = now();
            $age = $today->diffInYears(\Carbon\Carbon::parse($dob));

            return $age < 18 ? !empty($value) : true;
        });
        User::observe(UserObserver::class);
        //
        Collection::macro('toBadges', function ($class = 'badge-primary') {
            return new HtmlString($this->map(function ($value) use ($class) {
                return '<span class="badge fs-8 fw-bolder '.$class.' mb-1 me-1">'.$value.'</span>';
            })->implode(' '));
        });
    }
}
