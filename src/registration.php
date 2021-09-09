<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE, 'Tschallacka_MageStorm',
    __DIR__
);
$boot = new \Tschallacka\MageStorm\tools\BootEloquent();
$boot->bootOnce();