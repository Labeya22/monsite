<?php

namespace Query;

use PDO;

class Insert
{
    private $from = null;

    private $params = [];

    private $insert = [];

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

    public function insert(string ...$insert): self
    {
        $this->insert = array_merge($this->insert, $insert);

        return $this;
    }


    public function from(string $table): self
    {
        $this->from = $table;

        return $this;
    }

    public function __toString(): string
    {
        $query = ['INSERT INTO'];
        $query[] = $this->from;
        $query[] = 'SET';
        $query[] = implode(', ', $this->insert);

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