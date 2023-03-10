<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3eefc868272be3c149a008a7928b0ef0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'MediaWiki\\OAuthClient\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'MediaWiki\\OAuthClient\\' => 
        array (
            0 => __DIR__ . '/..' . '/mediawiki/oauthclient/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3eefc868272be3c149a008a7928b0ef0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3eefc868272be3c149a008a7928b0ef0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3eefc868272be3c149a008a7928b0ef0::$classMap;

        }, null, ClassLoader::class);
    }
}
