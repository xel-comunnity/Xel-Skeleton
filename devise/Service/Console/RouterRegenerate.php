<?php
    
namespace Xel\Devise\Service\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Xel\Async\Router\Attribute\Generate\extractClass;
use function Xel\Async\Router\Attribute\Generate\generateCacheClass;
use function Xel\Devise\Service\AppClassBinder\serviceRegister;

class RouterRegenerate extends Command
{
    protected static string $RouterRegenerate = 'router:regenerate';

    protected function configure(): void
    {
        $this->setName(self::$RouterRegenerate);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = __DIR__.'/../../../writeable/routerCache/';
        $classLoader = extractClass(serviceRegister());
        generateCacheClass($classLoader,  $path);

        $output->writeln('Router has been regenerated!!');
        return Command::SUCCESS;
    }
}
