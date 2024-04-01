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


class MigrationMigrate extends Command
{
    protected static string $MigrationMigrate = 'migration:migrate';

    protected function configure(): void
    {
        $this->setName(self::$MigrationMigrate)
            ->setDescription("migrate for db");
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
            if (!$conn->isDatabaseExists()){
                $conn->createDatabase();
                $conn = null;
            }

            $x = new Connection($config);

            MigrationManager::init($x->getConnection(), $load);
            MigrationManager::migrate();

            $output->writeln("Migration Success");

            return Command::SUCCESS;

        }catch (\PDOException|\Exception $e){
            $output->writeln('Migration failure : '.$e->getMessage());
            return Command::FAILURE;
        }
    }
}
