<?php
namespace Xel\Migration;
use Exception;
use Xel\DB\QueryBuilder\Migration\Migration;
use Xel\DB\QueryBuilder\Migration\Schema;
use Xel\DB\QueryBuilder\Migration\TableBuilder;

class a_users_roles extends Migration
{
    /**
     * @throws Exception
     */
    public function up(): void
    {
        Schema::create('a_users_roles',function (TableBuilder $tableBuilder){
            $tableBuilder->id()
                ->unsignedINT('user_id')
                ->unsignedINT('role_id')
                ->foreign('user_id','users','id')
                ->foreign('role_id','roles','id');
        })->execute();
    }

    /**
     * @throws Exception
     */
    public function down(): void
    {
        Schema::drop('a_users_roles');
    }
}
