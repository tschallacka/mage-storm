<?php

namespace Tschallacka\MageStorm\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Winter\Storm\Support\Str;

class CreateModel extends BaseCommand
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
        $this->setDescription('Create a  MageStorm model. Arguments: Module_Name ModelName [namespace(namespace path defaults to Models]');
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
        $module_name = $input->getArgument(self::MODULE_NAME);
        $model_name = $input->getArgument(self::MODEL_NAME);
        $path = $input->getArgument(self::PATH) ?? 'Models';
        $template = file_get_contents(__DIR__ . '/model.template');
        $root = str_replace('_','\\', $module_name);
        // just a little sanity check.
        $path = str_replace($root . '\\', '',  $path);
        $namespace = $root . '\\' . $path;
        $directory = BP . '/app/code/' . str_replace('_','/', $module_name) .
                            '/' .str_replace('\\','/', $path);
        $file_path = $directory . '/' . $model_name . '.php';
        if(is_file($file_path)) {
            $output->writeln("File $file_path already exists");
            return;
        }
        file_exists($directory) || mkdir($directory, 0777, true);
        $table_name = Str::snake($model_name);
        $rendered_model = str_replace([
            '{{ namespace }}',
            '{{ model_name }}',
            '{{ table_name }}',
        ],[
           $namespace,
           $model_name,
           $table_name
        ], $template);
        if(file_put_contents($file_path, $rendered_model)) {
            $output->writeln("Model $namespace\\$model_name has been created at $file_path");
            $output->writeln('Use the declarative schema to easily generate your database tables');
            $output->writeln("https://devdocs.magento.com/guides/v2.4/extension-dev-guide/declarative-schema/db-schema.html");
        }

    }
}
