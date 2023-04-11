<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

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
        // $settings = Setting::checkSettings();
        // view()->share([
        //     'settings'=>$settings,
        // ]);
        // if (app()->runningInConsole()){// tari2a tenyi bdal try catch

        // }
        try {
            $settings = Setting::checkSettings();
            $categories = Category::with('children')->where('parent', 0)->orWhere('parent', null)->get();
            $lastFivePosts = Post::with('category', 'user')->orderBy('id')->limit(5)->get();
            View()->share([
                'settings' => $settings,
                'categories' => $categories,
                'lastFivePosts' => $lastFivePosts,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
