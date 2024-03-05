<?php
    
namespace Xel\Devise\Service\Console;
use Dotenv\Dotenv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RouterDelete extends Command
{
    protected static string $RouterDelete = 'router:delete';

    protected function configure(): void
    {
        $this->setName(self::$RouterDelete);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
         * DOTENV init
         */
        $dotenv = Dotenv::createImmutable(__DIR__."/../../../");
        $dotenv->safeLoad();

        if ($_ENV['BUILD'] !== 'dev') {
            $path = __DIR__."/../../../writeable/routerCache/class.cache";
            if (!file_exists($path)){
                $output->writeln('Error : Router static cache file not found');
                return Command::FAILURE;
            }

            unlink($path);
            $output->writeln('Router static cache already removed');
            return Command::SUCCESS;
        }

        $output->writeln('Error : This command only use on production environment !!!');
        return Command::FAILURE;

    }
}
