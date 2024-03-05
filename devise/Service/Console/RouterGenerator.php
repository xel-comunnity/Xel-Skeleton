<?php

namespace Xel\Devise\Service\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Xel\Async\Router\Attribute\Generate\{generateCacheClass, extractClass};
use function Xel\Devise\Service\AppClassBinder\serviceRegister;
class RouterGenerator extends Command
{
    protected static string $defaultName = 'router:generate';

    protected function configure(): void
    {
        $this->setName(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = __DIR__.'/../../../writeable/routerCache/';
        $classLoader = extractClass(serviceRegister());
        generateCacheClass($classLoader,  $path);

        $output->writeln('Router has been generated!!');
        return Command::SUCCESS;
    }
}