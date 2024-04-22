<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isRouteActive')) {
    function isRouteActive($routes = []): bool
    {
        return in_array(Route::currentRouteName(), $routes);
    }
}
