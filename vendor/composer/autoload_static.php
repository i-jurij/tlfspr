<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0f41388a5641caafd48a23b2ac51d9d8
{
    public static $files = array (
        'a8d13e5f3c5445df2f63f88c416cc31e' => __DIR__ . '/../..' . '/app/configs/config.php',
        'bcfae047047c43805eec95bf9e567bd9' => __DIR__ . '/../..' . '/app/lib/function/func.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tests\\' => 6,
        ),
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Lib\\Traits\\' => 15,
            'App\\Lib\\' => 8,
            'App\\Controllers\\' => 16,
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'App\\Lib\\Traits\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/lib/traits',
        ),
        'App\\Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/lib',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0f41388a5641caafd48a23b2ac51d9d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0f41388a5641caafd48a23b2ac51d9d8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0f41388a5641caafd48a23b2ac51d9d8::$classMap;

        }, null, ClassLoader::class);
    }
}
