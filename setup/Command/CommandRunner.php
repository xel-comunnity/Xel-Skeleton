<?php

namespace Xel\Setup\Command;

use Exception;
use Symfony\Component\Console\Application;
use function Xel\Devise\Service\AppClassBinder\serviceConsoleRegister;

class CommandRunner
{
    private static array $commandInstance;
    /**
     * @throws Exception
     */
    public static function init(Application $app): void
    {
        self::makeInstance();
        $app->addCommands(
            self::$commandInstance
        );
        $app->run();
    }

    /**
     * @return void
     */
    private static function makeInstance(): void
    {
        $commandList = serviceConsoleRegister();

        foreach ($commandList as $item){
            /**
             * @var class-string $instance;
             */
            $instance = new $item();
            self::$commandInstance[] = $instance;
        }
    }
}