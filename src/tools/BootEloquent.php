<?php namespace Tschallacka\MageStorm\tools;

class BootEloquent
{
    function bootOnce()
    {
        static $once = true;
        if(!$once) {
            return;
        }
        $once = false;
        /**
         * This is the earliest we can boot this up.
         * We read the magento config and use it to make the default connections
         */
        $finder = new FindMagentoRoot();
        $path_to_env = $finder->getPathToMagentoRoot() . '/app/etc/env.php';
        $env = require($path_to_env);
        $manager = new \Winter\Storm\Database\Capsule\Manager();

        foreach ($env['db']['connection'] as $name => $config) {
            if (!array_key_exists('driver', $config))
                $config['driver'] = 'mysql';
            if (!array_key_exists('prefix', $config))
                $config['prefix'] = $env['db']['table_prefix'];
            if (!array_key_exists('database', $config))
                $config['database'] = $config['dbname'];
            if (!array_key_exists('charset', $config))
                $config['charset'] = 'utf8';
            if (!array_key_exists('collation', $config))
                $config['collation'] = 'utf8_unicode_ci';
            $manager->addConnection($config, $name);
        }
        if (array_key_exists('magestorm', $env) && array_key_exists('connections', $env['magestorm'])) {
            foreach ($env['magestorm']['connections'] as $name => $config) {
                $connections[] = $name;
                $manager->addConnection($config, $name);
            }
        }
        $manager->bootEloquent();
    }

}