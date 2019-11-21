<?php


namespace Partfix\QueryBuilder\Model;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\StatementPrepared;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;
use PDOException;
use Closure;
use Illuminate\Support\Facades\Event;

class MysqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        if(!isset($this->connection)) {
            $this->connection = $connection;
        }
    }


    protected function reset(): void
    {
        $this->query = new \stdClass;
    }

    /**
     * @inheritDoc
     */
    public function create(): SQLQueryBuilder
    {
        return new self($this->connection);
    }

    /**
     * @inheritDoc
     */
    public function select(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function join(string $table, string $first, string $second): SQLQueryBuilder
    {
        $this->query->base .= " INNER JOIN {$table} ON {$first} = {$second}";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function multiJoin(string $table, array $fields): SQLQueryBuilder
    {
        $join = " INNER JOIN {$table} ON ";
        $i = 0;
        foreach ($fields as $key => $field) {
            if($i > 0) {
                $join .= ' AND ';
            }
            $join .= "{$key} = {$field}";
            $i++;
        }
        $this->query->base .= $join;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new \Exception("WHERE can only be added to SELECT OR UPDATE");
        }

        // условие вида "WHERE post.id = comments.id"
        // стоит указывать как $builder->where('post.id', '{comments.id}'), что бы явно указать что это не просто строка
        $value = preg_match('/{.+}/',$value) ? preg_replace('/[{}]/', '', $value) : "'$value'";

        $this->query->where[] = "$field $operator $value";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereIn(string $field, $values)
    {

        if ($values instanceof Closure) {
            $this->query->where[] = "$field IN (".$values(new self($this->connection))->getQuery().")";

            return $this;
        }
        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new \Exception("WHERE IN can only be added to SELECT OR UPDATE");
        }
        $this->query->where[] = "$field IN ('".implode("','", $values)."')";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereExists(Closure $values)
    {
        $this->query->where[] = " EXISTS (".$values(new self($this->connection))->getQuery().")";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whereBetween(string $field, string $first, string $second): SQLQueryBuilder
    {
        $this->query->where[] = "$field BETWEEN $first AND $second";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function limit(int $limit): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $limit;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offset(int $offset)
    {
        if (!$this->query->limit) {
            throw new \Exception("OFFSET can only be added after LIMIT");
        }
        $this->query->limit .= " OFFSET " . $offset;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getQuery(): string
    {
        $query = $this->query;

        if(!$query) return "";

        $sql = $query->base;

        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }

        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        if (isset($query->groupBy)) {
            $sql .= $query->groupBy;
        }

        return $sql;
    }

    /**
     * @inheritDoc
     */
    public function groupBy(string $field)
    {
        $this->query->groupBy = " GROUP BY {$field}";

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getResult()
    {
        try {
            return $this->connection->select($this->getQuery());
        } catch (PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * @inheritDoc
     */
    public function getArrayResult()
    {
        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(\PDO::FETCH_ASSOC);
        });
        try {
            $exec =$this->connection->select($this->getQuery());
            Event::listen(StatementPrepared::class, function ($event) {
                $event->statement->setFetchMode(\PDO::FETCH_OBJ);
            });
            return $exec;
        } catch (PDOException $exception) {
            Event::listen(StatementPrepared::class, function ($event) {
                $event->statement->setFetchMode(\PDO::FETCH_OBJ);
            });
            throw new PDOException($exception);
        }
    }
}

