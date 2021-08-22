<?php

namespace Tschallacka\MageStorm\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModel extends Command
{
    const MODULE_NAME = "module_name";
    const MODEL_NAME = 'model_name';
    const PATH = 'path';
    protected $default_path = 'Models';
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('storm:create:model');
        $this->setDescription('Create a  MageStorm model. Arguments: Module_Name ModelName [path(path defaults to Models]');
        $this->addArgument(self::MODULE_NAME);
        $this->addArgument(self::MODEL_NAME);
        $this->addArgument(self::PATH);
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $arguments = $input->getArguments();
        print_r($arguments);
        /** @noinspection PhpComposerExtensionStubsInspection */
       //xdebug_break();
    }
}
