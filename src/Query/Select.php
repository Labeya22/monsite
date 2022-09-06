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

    private $offset = null;

    private $into = null;

    private $count = null;

    private $where = [];

    private $join = [];

    private $in = [];

    private $by = [];

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    


    /**
     * Envoie les valeurs de paramètres 
     *
     * @param array $params
     * @return self
     */
    public function params(array $params): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function count(string $count = 'id'): self
    {
        $this->count = "COUNT($count)";

        return $this;
    }

    public function in (string $key, string $in): self
    {
        $this->where = array_merge($this->where, ["$key IN ($in)"]);

        return $this;

    }

    

    /**
     *
     * @param string ...$select
     * @return self
     */
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
        $this->where = array_merge($this->where, $where);
        
        return $this;
    }

    public function by(string ...$by): self
    {
        $this->by = array_merge($this->by, $by);
        
        return $this;
    }

    public function join (string ...$join): self
    {
        $this->join = array_merge($this->join, $join);


        return $this;
    }

    /**
     * Permet de limiter les nombres des resultats à la sortie
     *
     * @param integer $limit 
     * @param integer|null $offset
     * @return self
     */
    public function limit (int $limit = 12, ?int $offset = null): self
    {
        $this->limit = $limit;

        // Je vérifie si l'offset est définie
        if (!is_null($offset)) {
            // on le définie
            $this->offset = $offset;
        }

        return $this;
    }

    
    /**
     * Execution de la requête.
     *
     * @return bool|array
     */
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


        
        if (!is_null($this->count)) {
            $query[] = $this->count;
        } elseif (!empty($this->select)) {
            $query[] = implode(', ', $this->select);
        } else {
            $query[] = '*';
        }

        if (is_null($this->from)) {
            throw new QueryException("vous devez preciser la table à laquelle vous souhaitez appliquer...");
        }
        
        $query[] = 'FROM ' .  $this->from;

        if (!empty($this->join)) {
            $query[] = implode(' ', $this->join);
        }

        if (!empty($this->where)) {
            $query[] = 'WHERE';
            $query[] = '(' . implode(') AND (', $this->where) . ')';
        }
        
        if (!empty($this->by)) {
            $query[] = 'ORDER BY';
            $query[] = implode(', ', $this->by);
        }


        if (!is_null($this->limit)) {
            $query[] = 'LIMIT';
            $query[] = $this->limit;

            if (!is_null($this->offset)) {
                $query[] = 'OFFSET';
                $query[] = $this->offset;
            }
        }

        
     
        return implode(' ', $query);
    }


    public function number(): int
    {
        // permet de compter les nombres des resultats dans une table.
        $query = $this->__toString();
        if (!empty($this->params)) {
            $requete =  $this->pdo->prepare($query);
            $requete->execute($this->params);
        } else {
            $requete =  $this->pdo->query($query);
        }
        
        return (int)$requete->fetch(PDO::FETCH_NUM)[0];
    }
}