<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
Use App\Models\User;
use Illuminate\Support\Facades\View;

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
        Gate::define('only-admin-and-author-have-rights', function (User $user) {
            return $user->role == 'admin' or $user->role == 'author';
        });

        $menuCategories = Category::all();
        View::share('menuCategories', $menuCategories);
    }
}
