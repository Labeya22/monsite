<?php

namespace Query;

use PDO;

class Update
{
    private $from = null;

    private $params = [];

    private $where = [];

    private $update = [];

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

    public function update(string ...$update): self
    {
        $this->update = array_merge($this->update, $update);

        return $this;
    }


    public function from(string $table): self
    {
        $this->from = $table;

        return $this;
    }

    public function where(string ...$where): self
    {
        $this->where = array_merge($this->where, $where);
        
        return $this;
    }

    public function __toString(): string
    {
        $query = ['UPDATE'];
        $query[] = $this->from;
        $query[] = 'SET';
        $query[] = implode(', ', $this->update);

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