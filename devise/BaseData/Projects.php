<?php

namespace Xel\Devise\BaseData;
use Exception;
use Xel\DB\QueryBuilder\QueryDML;

class Projects
{
    public string $table = 'projects';
    public array $permitted = [
        'user_id',
        'project_title',
        'deadline',
        'description',
        'reward_point',
        'file',
        'status',
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