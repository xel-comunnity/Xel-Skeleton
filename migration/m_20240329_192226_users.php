<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;
use function DI\string;

class m_20240329_192226_users extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('m_20240329_192226_users',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('name')
                ->string('email');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('m_20240329_192226_users');
    }
}
