<?php

namespace Tschallacka\MageStorm\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tschallacka\Test\Models\BaseModel;
use Winter\Storm\Support\Str;

class TestModel extends BaseCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('storm:test:model');
        $this->setDescription('quick \'n dirty testing');
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
        $model = new BaseModel(['name'=>'foobar']);
        $model->save();
        $new = BaseModel::find($model->getKey());
        xdebug_break();

    }
}
