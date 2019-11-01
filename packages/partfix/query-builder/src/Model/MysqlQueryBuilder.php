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
    /**
     * @var Connection
     */
    private $connection;

    /**
     * MysqlQueryBuilder constructor.
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
     * Создает новый инстанс класса
     * @return $this
     */
    public function create(): self
    {
        return new self($this->connection);
    }

    /**
     * Построение базового запроса SELECT.
     * @param string $table
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function select(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * Добавление условия INNER JOIN
     * @param string $table
     * @param $first
     * @param $second
     * @return SQLQueryBuilder
     */
    public function join(string $table, string $first, string $second): SQLQueryBuilder
    {
        $this->query->base .= " INNER JOIN {$table} ON {$first} = {$second}";

        return $this;
    }



    /**
     * Добавление условия WHERE
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     * @throws \Exception
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
     * Добавление условия WHERE IN
     * @param string $field
     * @param $values
     * @return $this
     * @throws \Exception
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
     * Добавление условия WHERE EXISTS
     * @param Closure $values
     * @return $this
     */
    public function whereExists(Closure $values)
    {
        $this->query->where[] = " EXISTS (".$values(new self($this->connection))->getQuery().")";

        return $this;
    }

    /**
     * Добавление условия BETWEEN
     * @param string $field
     * @param string $first
     * @param string $second
     * @return SQLQueryBuilder
     */
    public function whereBetween(string $field, string $first, string $second): SQLQueryBuilder
    {
        $this->query->where[] = "$field BETWEEN $first AND $second";

        return $this;
    }

    /**
     * Добавление ограничения LIMIT.
     * @param int $limit
     * @return SQLQueryBuilder
     * @throws \Exception
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
     * Добавление ограничения OFFSET.
     * @param int $offset
     * @return $this
     * @throws \Exception
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
     * Получение окончательной строки запроса.
     */
    public function getQuery(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

//        $sql .= " ;";

        return $sql;
    }

    /**
     * Возвращает результат строки запроса.
     * @return array
     */
    public function getResult()
    {
        try {
            return $this->connection->select($this->getQuery());
        } catch (PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    public function getArrayResult()
    {
        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(\PDO::FETCH_ASSOC);
        });
        try {
            return $this->connection->select($this->getQuery());
        } catch (PDOException $exception) {
            throw new PDOException($exception);
        }
    }
}

