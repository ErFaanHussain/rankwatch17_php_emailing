<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitefd4e01c68f52bf6a7e08e2bfd11521d
{
    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mandrill' => 
            array (
                0 => __DIR__ . '/..' . '/mandrill/mandrill/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitefd4e01c68f52bf6a7e08e2bfd11521d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}