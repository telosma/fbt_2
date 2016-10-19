<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquents\UserRepository;
use App;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
