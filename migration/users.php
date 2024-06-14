<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;
use function DI\string;

class users extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('users',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('name')
                ->string('email')
                ->string('password');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('users');
    }
}
