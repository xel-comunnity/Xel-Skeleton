<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class roles extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('roles',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('name');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('roles');
    }
}
