<?php
    
namespace Xel\Devise\Service\Console;
use Dotenv\Dotenv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Xel\Devise\Service\AppClassBinder\serviceRegister;
use function Xel\Async\Router\Attribute\Generate\loaderClass;

class RouterList extends Command
{
    protected static string $RouterList = "router:list";

    protected function configure(): void
    {
        $this->setName(self::$RouterList);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
         * DOTENV init
         */
        $dotenv = Dotenv::createImmutable(__DIR__."/../../../");
        $dotenv->safeLoad();
        /**
         * Env tabular print
         */
        $table = new Table($output);
        if ($_ENV['BUILD'] !== 'dev'){
            $path = __DIR__."/../../../writeable/routerCache/class.cache";
            if (!file_exists($path)){
                $output->writeln('error : file router cache not found, please generated first!!');
                return Command::FAILURE;
            }else{
                $routeList = require __DIR__."/../../../writeable/routerCache/class.cache";
            }
        } else {
            $routeList = loaderClass(serviceRegister(), __DIR__."/../../../writeable/routerCache");

        }

        foreach ($routeList as $router) {

            $table
                ->setHeaders(['URI', 'RequestMethod', 'Class', 'Method'])
                ->setRows([
                    [$router['Uri'],$router['RequestMethod'], $router['Class'], $router['Method']]
                ]);
        }
        $table->render();
        return Command::SUCCESS;
    }
}
