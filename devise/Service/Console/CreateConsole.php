<?php

namespace Xel\Devise\Service\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateConsole extends Command
{
    protected static string $defaultName = 'create:console';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Create custom Command Console')
            ->addArgument('value', InputArgument::REQUIRED, 'Name of Console Class.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commandClass = $input->getArgument('value');

        // Validate the class name
        if (!$this->isValidClassName($commandClass)) {
            echo 'Invalid class name. Please provide a valid class name.';
            return Command::FAILURE;
        }
        $dir = __DIR__."/../Console/";
        $extension = $dir."$commandClass.php";

        if (file_exists($extension)) {
            $output->writeln("Class file '$commandClass.php' already exists.");
            return Command::FAILURE;
        }

        $file = fopen($extension, 'w');
        if ($file){
            fwrite($file, $this->content($commandClass));
            fclose($file);
            chmod($extension, 0755);
            chown($extension, get_current_user());

            $output->writeln("Class file '$commandClass.php' has been created");
        }
        return Command::SUCCESS;
    }

    private function content(string $commandClass): string
    {
        /**
         * Check pattern of Argument
         */
        $classArgument = $this->checkPatternClass($commandClass);

        return "<?php
    
namespace Xel\Devise\Service\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class $classArgument extends Command
{
    protected static string $$classArgument;

    protected function configure(): void
    {
    }

    protected function execute(InputInterface \$input, OutputInterface \$output): int
    {        
        return Command::SUCCESS;
    }
}
";
    }

    private function isValidClassName(string $className): false|int
    {
        // Function to validate the class name
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $className);
    }

    private function checkPatternClass(string $command): false|string
    {
        if (str_contains($command, '/')) {
            // Pattern with slash found
            $parts = explode('/', $command);
            return end($parts);
        }

        return $command;
    }

}