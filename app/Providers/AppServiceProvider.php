<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Blade;
use App\Services\AssetLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register AssetLoader as singleton
        $this->app->singleton(AssetLoader::class, function ($app) {
            return new AssetLoader();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure Vite is properly configured
        if (class_exists(Vite::class)) {
            // Configure Vite for production
            Vite::macro('isRunningHot', function () {
                return is_file(public_path('hot'));
            });
        }
        
        // Create a custom Blade directive for loading CSS files manually
        Blade::directive('loadcss', function ($expression) {
            return "<?php echo app('App\\Services\\AssetLoader')->loadCss($expression); ?>";
        });
        
        // Create a custom Blade directive for loading JS files manually
        Blade::directive('loadjs', function ($expression) {
            return "<?php echo app('App\\Services\\AssetLoader')->loadJs($expression); ?>";
        });
    }
}
