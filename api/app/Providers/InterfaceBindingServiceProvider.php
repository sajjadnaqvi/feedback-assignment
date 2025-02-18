<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Repositories\FeedbackRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\FeedbackRepository;
use App\Repositories\UserRepository;

class InterfaceBindingServiceProvider extends ServiceProvider
{

    const BINDINGS = [
        CategoryRepository::class =>  CategoryRepositoryInterface::class,
        CommentRepository::class =>  CommentRepositoryInterface::class,
        FeedbackRepository::class =>  FeedbackRepositoryInterface::class,
        UserRepository::class =>  UserRepositoryInterface::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach(self::BINDINGS as $key => $binding)
        {
            $this->app->bind($key, $binding);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
