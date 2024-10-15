<?php

if (! function_exists('config')) {
    function config(string $key)
    {
        $keys = explode('.', $key);
        $file = array_shift($keys);

        $value = require __DIR__."/../../../../config/{$file}.php";

        foreach ($keys as $key) {
            $value = $value[$key] ?? null;
        }

        return $value;
    }
}

if (! function_exists('env')) {
    function env($name, $default = null)
    {
        return $_ENV[$name] ?? $default;
    }
}

if (! function_exists('storage_path')) {
    function storage_path($path = null)
    {
        $storagePath = __DIR__.'/../../../../storage';

        if (! $path) {
            return $storagePath;
        }

        return preg_replace('/\/+/', '/', $storagePath.'/'.$path);
    }
}
