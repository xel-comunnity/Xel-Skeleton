<?php
    
namespace Xel\Devise\Service\Console;
use Random\Randomizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TokenGeneratorConsole extends Command
{
    protected static string $TokenGeneratorConsole = "gemstone:generate";

    protected function configure(): void
    {
        $this
            ->setName(self::$TokenGeneratorConsole)
            // the command description shown when running "php bin/console list"
            ->setDescription('Generate Secret Token')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to Generate Secret Token')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $envPath = $this->getProjectDir().'/.env';
        $env = file_get_contents($envPath);

        if (preg_match("/^GEMSTONE_SECRET=/m", $env)) {
            $env = preg_replace("/^GEMSTONE_SECRET=.*/m", "GEMSTONE_SECRET={$this->generateSecretKey()}", $env);
        } else {
            $env .= "\nGEMSTONE_SECRET={$this->generateSecretKey()}";
        }

        file_put_contents($envPath, $env);
        return Command::SUCCESS;
    }

    private function getProjectDir(): string
    {
        // Adjust this path as needed if your command is located elsewhere.
        return dirname(__DIR__, 3);
    }

    private function generateSecretKey(): string
    {
        $data = new Randomizer();
        return bin2hex($data->getBytes(32));
    }
}
