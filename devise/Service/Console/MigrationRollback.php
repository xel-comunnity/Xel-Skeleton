<?php
    
namespace Xel\Devise\Service\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xel\DB\QueryBuilder\Migration\Connection;
use Xel\DB\QueryBuilder\Migration\MigrationManager;
use Xel\DB\QueryBuilder\MigrationLoader;

class MigrationRollback extends Command
{
    protected static string $MigrationRollback = 'migration:rollback';

    protected function configure(): void
    {
        $this->setName(self::$MigrationRollback)
            ->setDescription("migrate rollback for db with for specific and all migration include");
        $this->addArgument('value', InputArgument::OPTIONAL, 'rollBack Pointer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $input->getArgument('value') ?? "*";
        $step = intval($data);

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
            MigrationManager::rollback($step);

            $output->writeln("Migration Success");

            return Command::SUCCESS;

        }catch (\PDOException|\Exception $e){
            $output->writeln('Migration failure : '.$e->getMessage());
            return Command::FAILURE;
        }
    }

}
