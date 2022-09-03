<?php

namespace Query;

use PDO;

class Delete
{
    private $from = null;

    private $params = [];

    private $where = [];

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function params(array $params): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->from = !is_null($alias) ? $table . ' ' . $alias : $table;

        return $this;
    }

    public function where(string ...$where): self
    {
        $this->where = array_merge($this->where, $where);
        
        return $this;
    }

    public function __toString(): string
    {
        $query = ['DELETE'];
        $query[] = 'FROM ' .  $this->from;

        if (!empty($this->where)) {
            $query[] = 'WHERE';
            $query[] = '(' . implode(') AND (', $this->where) . ')';
        }


        return implode(' ', $query);

    }

    public function execute(): bool
    {
        $query = $this->__toString();

        if (!empty($this->params)) {
            $requete = $this->pdo->prepare($query);
            return $requete->execute($this->params);
        }
        else {
            return $this->pdo->query($query)->execute();
        }
        
    }

}