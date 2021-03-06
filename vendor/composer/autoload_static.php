<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf3e713f554ffaf2013b72036465e7cc5
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf3e713f554ffaf2013b72036465e7cc5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf3e713f554ffaf2013b72036465e7cc5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
