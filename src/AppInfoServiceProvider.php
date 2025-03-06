<?php
namespace EngrShishir\AppInfo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppInfoServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-app-info', function ($app) {
            return new \EngrShishir\AppInfo\AppInfo();
        });

        // Merge the package's config file with the user's config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/app-info.php',
            'app-info'
        );
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Automatically register the route from the 'routes/web.php' in your package
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        
        // Automatically load the views from the package to the user's application for customization
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'app-info');
        
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../config/app-info.php' => config_path('app-info.php'),
        ], 'config');
        
        // Call method to append routes
        $this->appendRoutesToWeb();

        // Ensure the app-info.blade.php view exists in the resources/views directory
        $this->ensureViewExists();
    }

    /**
     * Ensure that the app-info.blade.php view exists in resources/views
     */
    private function ensureViewExists()
    {
        $viewPath = resource_path('views/app-info.blade.php');

        // Check if the view already exists
        if (!File::exists($viewPath)) {
            // If not, copy the view from the package's resources/views
            $source = __DIR__ . '/../resources/views/app-info.blade.php';
            File::copy($source, $viewPath);  // Copy the view to the appropriate location
        }
    }

    private function appendRoutesToWeb()
    {
        $webPath = base_path('routes/web.php');
    
        // Read the current content of the web.php file
        $content = file_get_contents($webPath);
    
        // Check if 'use EngrShishir\AppInfo\Facades\AppInfo;' is already present
        if (strpos($content, 'use EngrShishir\AppInfo\Facades\AppInfo;') === false) {
            // If not, add it after the <?php tag
            $useAppInfo = PHP_EOL . "use EngrShishir\AppInfo\Facades\AppInfo;" . PHP_EOL;
            $content = preg_replace('/<\?php/', '<?php' . $useAppInfo, $content, 1);
        }
    
        // Define the new route code to insert
        $newRoute = PHP_EOL . "// new code" . PHP_EOL;
        $newRoute .= "Route::get('/app-info', function () {" . PHP_EOL;
        $newRoute .= "    return view('app-info', [" . PHP_EOL;
        $newRoute .= "        'envs'=> AppInfo::getAllEnv()," . PHP_EOL;
        $newRoute .= "        'routes'=> AppInfo::getAllRoutes()," . PHP_EOL;
        $newRoute .= "        'packages'=> AppInfo::getAllPackages()" . PHP_EOL;
        $newRoute .= "    ]);" . PHP_EOL;
        $newRoute .= "});" . PHP_EOL;

        // Check if the custom route already exists to avoid duplication
        if (strpos($content, '/app-info') === false) {
            // Find the last 'use' statement and append the new route after it
            $lastUsePosition = strrpos($content, 'use '); // Find the last 'use' statement
            if ($lastUsePosition !== false) {
                // Insert the new route code after the last 'use' statement
                $content = substr_replace($content, PHP_EOL . $newRoute, $lastUsePosition + strlen('use EngrShishir\AppInfo\Facades\AppInfo;') + 1, 0);
            }
        }
    
        // Write the modified content back to the web.php file
        file_put_contents($webPath, $content);
    }
}
