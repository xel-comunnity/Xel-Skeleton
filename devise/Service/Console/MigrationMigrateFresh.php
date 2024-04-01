<?php
    
namespace Xel\Devise\Service\Console;
use Exception;
use ReflectionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xel\DB\QueryBuilder\Migration\Connection;
use Xel\DB\QueryBuilder\Migration\MigrationManager;
use Xel\DB\QueryBuilder\MigrationLoader;


class MigrationMigrateFresh extends Command
{
    protected static string $MigrationMigrateFresh = 'migration:fresh';

    protected function configure(): void
    {
        $this->setName(self::$MigrationMigrateFresh)
            ->setDescription("migrate fresh for db");
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = require __DIR__."/../../../setup/Config/DBConfig.php";
        try {
            $conn = new Connection($config);
            $load = new MigrationLoader(__DIR__."/../../../migration/", $config['migration']);
            $load->load();


            MigrationManager::init($conn->getConnection(), $load);
            MigrationManager::freshMigrate();

            $output->writeln("Migration fresh Success");

            return Command::SUCCESS;

        }catch (\PDOException|\Exception $e){
            $output->writeln('Migration failure : '.$e->getMessage());
            return Command::FAILURE;
        }
    }
}
