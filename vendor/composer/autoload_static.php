<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit25e3f6799e2f4e6e7662c3a0b45bc065
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Zebra_Pagination' => __DIR__ . '/..' . '/stefangabos/zebra_pagination/Zebra_Pagination.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit25e3f6799e2f4e6e7662c3a0b45bc065::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit25e3f6799e2f4e6e7662c3a0b45bc065::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit25e3f6799e2f4e6e7662c3a0b45bc065::$classMap;

        }, null, ClassLoader::class);
    }
}
