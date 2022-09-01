<?php


namespace Query;

use App\Exceptions\QueryException;
use PDO;


class Select
{
    private $select = [];

    private $from = null;

    private $params = [];

    private $limit = null;

    private $into = null;

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Envoie les valeurs de paramètres 
     *
     * @param array ...$params
     * @return self
     */
    public function params(array ...$params): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }


    public function select (string ...$select): self
    {
        $this->select = array_merge($this->select, $select);

        return $this;
    }

    public function into ($into): self
    {
        $this->into = $into;

        return $this;
    }


    /**
     * Permet de définir le nom de la table
     *
     * @param string $table
     * @param string|null $alias
     * @return self
     */
    public function from(string $table, ?string $alias = null): self
    {
        $this->from = !is_null($alias) ? $table . ' ' . $alias : $table;

        return $this;
    }

    public function where(string ...$where): self
    {
        
        return $this;
    }

    public function limit (int $limit = 12): self
    {
        $this->limit = $limit;

        return $this;
    }

    
    public function execute()
    {
        $query = $this->__toString();


        if (!empty($this->params)) {
            $requete = $this->pdo->prepare($query);
            $requete->execute($this->params);
        }
        else {
            $requete = $this->pdo->query($query);
        }

        if (!is_null($this->into)) {
            return $requete->fetchAll(PDO::FETCH_CLASS, $this->into);
        }

        return $requete->fetchAll();
    }

    public function __toString(): string
    {
        $query = ['SELECT'];

        if (!empty($this->select)) {
            $query[] = implode(', ', $this->select);
        } else {
            $query[] = '*';
        }

        if (is_null($this->from)) {
            throw new QueryException("vous devez preciser la table à laquelle vous souhaitez appliquer...");
        }

        
        $query[] = 'FROM ' .  $this->from;

        if (!is_null($this->limit)) {
            $query[] = 'LIMIT';
            $query[] = $this->limit;
        }

        return implode(' ', $query);
    }
}