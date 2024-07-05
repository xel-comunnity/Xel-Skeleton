<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class transfer extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('transfer',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('amount')
                ->string('recipient');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('transfer');
    }
}
