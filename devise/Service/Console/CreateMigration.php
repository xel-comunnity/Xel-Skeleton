<?php
    
namespace Xel\Devise\Service\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMigration extends Command
{
    protected static string $CreateMigration = "migration:create";

    protected function configure(): void
    {
        $this
            ->setName(self::$CreateMigration)
            ->setDescription('Create custom Command Console')
            ->addArgument('value', InputArgument::REQUIRED, 'Name of migration Class.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $valueClass = $input->getArgument('value');
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d_H-i-s');
        $data = str_replace('-','', $currentDateTime);
        $commandClass = "m_{$data}_$valueClass";
        
        // Validate the class name
        if (!$this->isValidClassName($commandClass)) {
            echo 'Invalid class name. Please provide a valid class name.';
            return Command::FAILURE;
        }
        $dir = __DIR__."/../../../migration/";
        $extension = $dir."$commandClass.php";

        if (file_exists($extension)) {
            $output->writeln("Class file '$commandClass.php' already exists.");
            return Command::FAILURE;
        }

        $file = fopen($extension, 'w');
        if ($file){
            fwrite($file, $this->content($commandClass));
            fclose($file);
            chmod($extension, 0755);
            chown($extension, get_current_user());

            $output->writeln("Class file '$commandClass.php' has been created");
        }
        return Command::SUCCESS;
    }

    private function content(string $commandClass): string
    {
        /**
         * Check pattern of Argument
         */
        $classArgument = $this->checkPatternClass($commandClass);

        return "<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class $commandClass extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('$commandClass',function (TableBuilder \$tableBuilder){
            
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('$commandClass');
    }
}
";
    }

    private function isValidClassName(string $className): false|int
    {
        // Function to validate the class name
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $className);
    }

    private function checkPatternClass(string $command): false|string
    {
        if (str_contains($command, '/')) {
            // Pattern with slash found
            $parts = explode('/', $command);
            return end($parts);
        }

        return $command;
    }
}
