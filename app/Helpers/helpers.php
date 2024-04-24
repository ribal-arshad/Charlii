<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isRouteActive')) {
    function isRouteActive($routes = []): bool
    {
        return in_array(Route::currentRouteName(), $routes);
    }
}

if (!function_exists('colorDropDown')) {
    function colorDropDown($colors, $default = '')
    {
        $options = '<option value="">Please select</option>';
        foreach ($colors as $color) {
            $options .= '<option value="' . $color->id . '" style="background-color:' . $color->color_code . '; color:' . $color->foreground_color . ';"' . (($default == $color->id) ? ' selected' : '') . '>' . $color->color . '</option>';
        }

        return '<select class="form-select" name="color_id" id="color_id">' . $options . '</select>';
    }
}
