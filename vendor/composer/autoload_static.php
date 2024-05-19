<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3b0226c39dfcd7e2b59ee179d3fda2a4
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'William\\TechniqueDb\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'William\\TechniqueDb\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/MVC',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3b0226c39dfcd7e2b59ee179d3fda2a4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3b0226c39dfcd7e2b59ee179d3fda2a4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3b0226c39dfcd7e2b59ee179d3fda2a4::$classMap;

        }, null, ClassLoader::class);
    }
}