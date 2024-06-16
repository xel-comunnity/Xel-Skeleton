<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class crud extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('crud',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('name')
                ->text('description')
                ->string('image');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('crud');
    }
}
