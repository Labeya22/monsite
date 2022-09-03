<?php

namespace Tables;

use PDO;
use Query\Select;
use App\Exceptions\TableException;

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


    public function all(): array
    {
        return $this->getSelect()->from($this->from)->into($this->mapping)->execute();
    }

    public function find ($key): array
    {
        $query =  $this->getSelect()->from($this->from)->into($this->mapping);
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $query->where("$k = :$k")->params([":$k" => $v]);
            }
        } else {
            $query->where('id = :id')->params([':id' => $key]);
        }

        return $query->execute();
    }
}