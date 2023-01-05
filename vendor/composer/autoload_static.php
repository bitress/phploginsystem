<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit429e70121bb6ffdbb79ea2a3fb49a6d0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'H' => 
        array (
            'Hybridauth\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Hybridauth\\' => 
        array (
            0 => __DIR__ . '/..' . '/hybridauth/hybridauth/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit429e70121bb6ffdbb79ea2a3fb49a6d0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit429e70121bb6ffdbb79ea2a3fb49a6d0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit429e70121bb6ffdbb79ea2a3fb49a6d0::$classMap;

        }, null, ClassLoader::class);
    }
}
