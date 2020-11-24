<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1dd75894d3ffa9ce7587056a99359ccc
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\' => 4,
        ),
        'O' => 
        array (
            'Opis\\Database\\' => 14,
        ),
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Libraries\\' => 14,
            'App\\Core\\' => 9,
            'App\\Controllers\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Opis\\Database\\' => 
        array (
            0 => __DIR__ . '/..' . '/opis/database/src',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'App\\Libraries\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/libraries',
        ),
        'App\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/core',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1dd75894d3ffa9ce7587056a99359ccc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1dd75894d3ffa9ce7587056a99359ccc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1dd75894d3ffa9ce7587056a99359ccc::$classMap;

        }, null, ClassLoader::class);
    }
}
