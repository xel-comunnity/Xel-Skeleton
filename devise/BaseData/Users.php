<?php

namespace Xel\Devise\BaseData;

use Exception;
use Xel\DB\QueryBuilder\QueryDML;

class Users
{
    public string $table = 'users';
    public array $permitted = [
        'email',
        'password'
    ];

    public function __construct(private readonly QueryDML $queryDML)
    {}

    /**
     * @throws Exception
     */
    public function selectAll(): array
    {
        return $this
            ->queryDML
            ->select($this->permitted)
            ->from($this->table)
            ->get();
    }
}