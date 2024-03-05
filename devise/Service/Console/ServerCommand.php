<?php

namespace Xel\Devise\Service\Console;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xel\Setup\Bootstrap\App;

class ServerCommand extends Command
{
   public function __construct(?string $name = null)
   {
       parent::__construct($name);
   }
    protected function configure(): void
    {
        $this
            ->setName('start')
            // the command description shown when running "php bin/console list"
            ->setDescription('Start Server')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to start rest api http server')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $app = new App();
        try {
            $app->init();
        } catch (DependencyException|NotFoundException|Exception $e) {
            echo "error : ".$e->getMessage();
        }
        return Command::SUCCESS;
    }

}