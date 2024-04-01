<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class m_20240329_192231_roles extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('m_20240329_192231_roles',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->string('name');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('m_20240329_192231_roles');
    }
}
