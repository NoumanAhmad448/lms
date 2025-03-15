<?php

namespace Eren\Lms\Helpers;

class AssetHelper
{
    protected static $namespaces = [];

    public static function addNamespace($namespace, $path)
    {
        self::$namespaces[$namespace] = $path;
    }

    public static function asset($path)
    {
        foreach (self::$namespaces as $namespace => $basePath) {
            if (str_starts_with($path, $namespace . '::')) {
                $path = str_replace($namespace . '::', '', $path);
                return app('url')->asset($basePath . '/' . $path);
            }
        }

        return app('url')->asset($path);
    }
}