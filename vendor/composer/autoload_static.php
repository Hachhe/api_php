<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited38f7d82d835819930e57ccd93d86bd
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited38f7d82d835819930e57ccd93d86bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited38f7d82d835819930e57ccd93d86bd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited38f7d82d835819930e57ccd93d86bd::$classMap;

        }, null, ClassLoader::class);
    }
}