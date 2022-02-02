<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;



class AppServiceProvider extends ServiceProvider
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
        Schema::defaultStringLength(191);
        paginator::useBootstrap();
        $settings=Setting::checksettings();
        $categories = Category::with('childern')->where('parent', 0)->orwhere('parent', null)->get();
        $last_with_post = Post::with('user', 'category')->orderBy('id')->limit(5)->get();
        view()->share([ 
            'setting'=>$settings,
            'categories'=>$categories,
            'last_with_post'=>$last_with_post,
        ]);

    }
}
