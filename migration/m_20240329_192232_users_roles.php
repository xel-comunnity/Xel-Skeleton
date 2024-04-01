<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class m_20240329_192232_users_roles extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('m_20240329_192232_users_roles',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->unsignedINT('user_id')
                ->unsignedINT('role_id')
                ->foreign('user_id','m_20240329_192226_users','id')
                ->foreign('role_id','m_20240329_192231_roles','id');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('m_20240329_192232_users_roles');
    }
}
