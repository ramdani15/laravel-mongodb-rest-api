<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class PolymorphicMappingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'User' => 'App\Models\User',
            'Vehicle' => 'App\Models\Vehicle',
            'Car' => 'App\Models\Car',
            'Motorcycle' => 'App\Models\Motorcycle',
            'Order' => 'App\Models\Order',
        ]);
    }
}
