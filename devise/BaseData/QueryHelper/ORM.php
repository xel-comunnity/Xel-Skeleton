<?php

namespace Xel\Devise\BaseData\QueryHelper;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
trait ORM
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function findAll(string $table): array
    {
        return $this->getQueryBuilder()
            ->select()
            ->from($table)
            ->get();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function findById(string $table, $id): array
    {
        return $this->getQueryBuilder()
            ->select()
            ->from($table)
            ->where('id', '=', $id)
            ->get();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function latest(string $table, int $limit): array
    {
        return $this->getQueryBuilder()
            ->select()
            ->from($table)
            ->latest($limit)
            ->get();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function create(string $table, array $bind): bool
    {
        $this->getQueryBuilder()
            ->insert($table, $bind)
            ->run();
        return true;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function update(string $table, array $bind, array $column): void
    {
        $this->getQueryBuilder()
            ->update($table, $bind)->where(array_key_first($column), '=', $column[0])
            ->run();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function delete(string $table, array $condition): void
    {
        $this->getQueryBuilder()
            ->delete($table)
            ->where(array_key_first($condition), '=',  $condition[0])
            ->run();
    }

    /***
     * Custom field for mini ORM
     */
    public function createWhere()
    {}
    public function updateWhere()
    {}

    /**
     * @param string $table1
     * @param string $table2
     * @param string $condition
     * @return array|null
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function oneToMany(string $table1, string $table2, string $condition): ?array
    {
        return $this->getQueryBuilder()->select()
            ->from($table1)->innerJoin($table2, $condition)
            ->get();
    }

    /***
     * @param string $table1
     * @param string $table2
     * @param string $pivot
     * @param array $condition
     * @return array|null
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function manyToMany(string $table1, string $table2, string $pivot, array $condition): ?array
    {
        return $this->getQueryBuilder()->select()
            ->from($table1)
            ->innerJoin($pivot, $condition[0])
            ->innerJoin($table2, $condition[1])
            ->get();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function oneToOne(string $table1, string $table2, string $condition): array
    {
        return $this->getQueryBuilder()->select()
            ->from($table1)->innerJoin($table2, $condition)
            ->getAsync();
    }
}