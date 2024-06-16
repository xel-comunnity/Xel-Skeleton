<?php

namespace Xel\MigrationSeeder;

use PDOException;

trait SeederUtility
{
    protected function singularize(string $word): string
    {
        return rtrim($word, 's');
    }

    public function seedTable(string $tableName, array $data): void
    {
        if (empty($data)) {
            return;
        }

        $columns = implode(', ', array_keys($data[0]));
        $placeholders = implode(', ', array_fill(0, count($data[0]), '?'));

        $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $this->queryDML->prepare($query);

        foreach ($data as $row) {
            try {
                $stmt->execute(array_values($row));
            } catch (PDOException $e) {
                error_log("Error seeding table $tableName: " . $e->getMessage());
                throw $e;
            }
        }
    }

    public function seedOneToMany(string $parentTable, string $childTable, array $parentData, array $childData, string $foreignKey): void
    {
        try {
            $this->seedTable($parentTable, $parentData);

            $lastParentId = $this->queryDML->lastInsertId();

            foreach ($childData as &$childRow) {
                $childRow[$foreignKey] = $lastParentId;
            }

            $this->seedTable($childTable, $childData);
        } catch (PDOException $e) {
            error_log("Error in seedOneToMany: " . $e->getMessage());
            throw $e;
        }
    }

    public function seedOneToOne(string $parentTable, string $childTable, array $parentData, array $childData, string $foreignKey): void
    {
        try {
            $this->seedTable($parentTable, $parentData);

            $lastParentId = $this->queryDML->lastInsertId();
            $childData[0][$foreignKey] = $lastParentId;

            $this->seedTable($childTable, $childData);
        } catch (PDOException $e) {
            error_log("Error in seedOneToOne: " . $e->getMessage());
            throw $e;
        }
    }

    public function seedManyToMany(string $table1, string $table2, string $pivotTable, array $data1, array $data2, array $relations): void
    {
        try {
            $this->seedTable($table1, $data1);
            $this->seedTable($table2, $data2);

            $column1 = $this->singularize($table1) . '_id';
            $column2 = $this->singularize($table2) . '_id';

            $pivotData = [];
            foreach ($relations as $relation) {
                $pivotData[] = [
                    $column1 => $relation[0],
                    $column2 => $relation[1]
                ];
            }

            $this->seedTable($pivotTable, $pivotData);
        } catch (PDOException $e) {
            error_log("Error in seedManyToMany: " . $e->getMessage());
            throw $e;
        }
    }
}