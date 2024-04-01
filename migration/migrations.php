<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class migrations extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('migrations',function (TableBuilder $tableBuilder){
            $tableBuilder
                ->id()
                ->string('migration');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('migrations');
    }
}
