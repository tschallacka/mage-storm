<?php

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Winter\Storm\Database\Capsule\Manager;

class Boot implements ObserverInterface
{
    protected Manager $manager;
    protected ResourceConnection $resource;

    public function __construct(Manager $manager, Magento\Framework\App\ResourceConnection $resource)
    {
        $this->manager = $manager;
        $this->resource = $resource;
    }
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $this->manager->addConnection($this->resource->getConnection());
        $this->manager->bootEloquent();
    }
}