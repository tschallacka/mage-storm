<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE, 'Tschallacka_MageStorm',
    __DIR__
);

$env = require(MAGENTO_BP . '/app/etc/env.php');
$manager = new \Winter\Storm\Database\Capsule\Manager();
foreach($env['db']['connection'] as $name => $config) {
    if(!array_key_exists('driver', $config))
    $config['driver'] = 'mysql';
    if(!array_key_exists('prefix', $config))
    $config['prefix'] = $env['db']['table_prefix'];
    if(!array_key_exists('database', $config))
    $config['database'] = $config['dbname'];
    if(!array_key_exists('charset', $config))
    $config['charset'] = 'utf8';
    if(!array_key_exists('collation', $config))
    $config['collation'] = 'utf8_unicode_ci';
    $manager->addConnection($config, $name);
}
foreach($env['magestorm']['connections'] as $name => $config)
{
    $manager->addConnection($config, $name);
}
$manager->bootEloquent();