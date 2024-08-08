<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
     */
    public function boot(): void
    {
        //$this->registerPolicies();

        Gate::define('update-dish', function (User $user, Dish $dish) {
            $restaurant = $user->restaurant;
            return $restaurant->id === $dish->restaurant_id;
        });

        Gate::define('update-restaurant', function (User $user, Restaurant $restaurant) {
            return $restaurant->user_id === $user->id;
        });

        Gate::define('update-order', function (User $user, Order $order) {
            $restaurant = $user->restaurant;
            //dd($restaurant->id,$order->restaurant_id);
            return $restaurant->id === $order->restaurant_id;
        });
    }
}
