<?php

namespace Tables;

use PDO;
use Query\Select;
use App\Exceptions\TableException;
use Query\Delete;
use Query\Insert;
use Query\Update;

class Table
{
    private $pdo = null;

    protected $from = null;

    protected $mapping = null;
    
    /**
     * Table Constructor
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        if (is_null($this->from)) {
            throw new TableException("L'attribue table ne peut pas être vide");
        }

        if (is_null($this->mapping)) {
            throw new TableException("L'attribue mapping ne peut pas être vide");
        }

        $this->pdo = $pdo;
    }

    public function getSelect(): Select
    {
        return new Select($this->pdo);
    }

    public function getDelete(): Delete
    {
        return new Delete($this->pdo);
    }

    public function getUpdate(): Update
    {
        return new Update($this->pdo);
    }

    public function getInsert(): Insert
    {
        return new Insert($this->pdo);
    }


    public function all(array $fields = []): array
    {
        $field = '*';
        if (!empty($fields)) {
            $field = implode(', ', $fields);
        }
        return $this->getSelect()->select($field)->from($this->from)->execute();
    }


    public function delete ($id): bool
    {
        return $this->getDelete()->from($this->from)->where("id = :id")->params([":id" => $id])->execute();
    }


    public function find (string $field, string $value, $index = null): array
    {
        $query =  $this->getSelect()->from($this->from)->into($this->mapping);
        if (is_null($index)) {
            $query->where("$field = :$field")->params([":$field" => $value]);
        } else {
            $query
            ->where("$field = :$field")
            ->where("id != :id")
            ->params([":$field" => $value])
            ->params([":id" => $index]);
        }

        return $query->execute();
    }

}