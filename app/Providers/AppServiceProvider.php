<?php

namespace App\Providers;

use App\Http\Contracts\CommentRepositoryInterface;
use App\Http\Contracts\LikeRepositoryInterface;
use App\Http\Contracts\PostRepositoryInterface;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\LikeRepository;
use App\Http\Repositories\PostRepository;
use App\Interfaces\CompanyInterface;
use App\Repositories\CompanyRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->singleton(   //$this->app->bind
          CompanyInterface::class,
            CompanyRepository::class

        );
        $this->app->singleton(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->singleton(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
        $this->app->singleton(
            LikeRepositoryInterface::class,
            LikeRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
