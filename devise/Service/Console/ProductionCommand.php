<?php

namespace Xel\Devise\Service\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductionCommand extends Command
{
    protected static string $defaultName = 'app:version';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Updates a variable in the .env file.')
            ->addArgument('value', InputArgument::REQUIRED, 'The new value of the variable.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = 'BUILD';
        $value = $input->getArgument('value');

        $envPath = $this->getProjectDir().'/.env';
        $env = file_get_contents($envPath);

        if (preg_match("/^{$name}=/m", $env)) {
            $env = preg_replace("/^{$name}=.*/m", "{$name}={$value}", $env);
        } else {
            $env .= "\n{$name}={$value}";
        }

        file_put_contents($envPath, $env);

        $output->writeln("The .env variable '{$name}' has been updated to '{$value}'.");

        return Command::SUCCESS;
    }

    private function getProjectDir(): string
    {
        // This assumes that this command is located in the default directory.
        // Adjust this path as needed if your command is located elsewhere.
        return \dirname(__DIR__, 3);
    }
}