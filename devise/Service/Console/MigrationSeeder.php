<?php
    
        namespace Xel\Devise\Service\Console;
        use Symfony\Component\Console\Command\Command;
        use Symfony\Component\Console\Input\InputInterface;
        use Symfony\Component\Console\Output\OutputInterface;
        use Xel\DB\QueryBuilder\Migration\Connection;
        use Xel\MigrationSeeder\MigrationSeederGenerator;

        class MigrationSeeder extends Command
        {
            protected static string $MigrationSeeder = 'migration:breed';

            protected function configure(): void
            {

                $this->setName(self::$MigrationSeeder)
                    ->setDescription("Fill your table with dev dummy data");
            }

            protected function execute(InputInterface $input, OutputInterface $output): int
            {
                $config = require __DIR__."/../../../setup/Config/DBConfig.php";
                try {
                    $conn = new Connection($config);
                    if (!$conn->isDatabaseExists()){
                        $conn->createDatabase();
                        $conn = null;
                    }

                    $conn = new Connection($config);
                    $seeder = new MigrationSeederGenerator($conn->getConnection());
                    $seeder->breed();

                    $output->writeln("Migration Success");
                    return Command::SUCCESS;

                }catch (\PDOException|\Exception $e){
                    $output->writeln('Migration failure : '.$e->getMessage());
                    return Command::FAILURE;
                }            }
        }
        