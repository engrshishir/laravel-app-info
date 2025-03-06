<?php

namespace EngrShishir\AppInfo;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class AppInfo
{

    public function getAllEnv(): array
    {
        return getenv();
    }


    public function getAllRoutes(): array
    {
        $routes = Route::getRoutes();
        $routeInfo = [
            'get' => [],
            'post' => [],
            'put' => [],
            'delete' => []
        ];
    
        foreach ($routes as $route) {
            $routeName = $route->getName();  // Get route name
    
            if (in_array('GET', $route->methods)) {
                $routeInfo['get'][] = [
                    'uri' => $route->uri,
                    'name' => $routeName
                ];
            }
            if (in_array('POST', $route->methods)) {
                $routeInfo['post'][] = [
                    'uri' => $route->uri,
                    'name' => $routeName
                ];
            }
            if (in_array('PUT', $route->methods)) {
                $routeInfo['put'][] = [
                    'uri' => $route->uri,
                    'name' => $routeName
                ];
            }
            if (in_array('DELETE', $route->methods)) {
                $routeInfo['delete'][] = [
                    'uri' => $route->uri,
                    'name' => $routeName
                ];
            }
        }
    
        return $routeInfo;
    }
    
    public function getAllPackages(): array
    {
        return json_decode(file_get_contents(base_path('composer.lock')), true)['packages'];
    }
}
