<?php 
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->bind(
            'App\Repositories\UserBidRepositoryInterface',
            'App\Repositories\UserBidRepository',
        );

        $this->app->bind(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\ProductRepository',
        );
    }
}