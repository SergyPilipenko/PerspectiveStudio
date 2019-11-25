<?php


namespace Partfix\QueryBuilder\Contracts;
use Closure;
use Partfix\QueryBuilder\Model\MysqlQueryBuilder;


interface SQLQueryBuilder
{
    /**
     * Создает новый инстанс класса
     * @return SQLQueryBuilder
     */
    public function create(): SQLQueryBuilder;

    /**
     * Построение базового запроса SELECT.
     * @param string $table
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function select(string $table, array $fields): SQLQueryBuilder;

    /**
     * Добавление условия INNER JOIN
     * @param string $table
     * @param $first
     * @param $second
     * @return SQLQueryBuilder
     */
    public function join(string $table, string $first, string $second): SQLQueryBuilder;

    /**
     * Work around
     * @param string $table
     * @param array $fields
     * @return SQLQueryBuilder
     */
    public function multiJoin(string $table, array $fields): SQLQueryBuilder;

    /**
     * Добавление условия WHERE
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return SQLQueryBuilder
     * @throws \Exception
     */
    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder;

    /**
     * Добавление условия WHERE IN
     * @param string $field
     * @param $values
     * @return $this
     * @throws \Exception
     */
    public function whereIn(string $field, $values);

    /**
     * Добавление условия WHERE EXISTS
     * @param Closure $values
     * @return $this
     */
    public function whereExists(Closure $values);

    /**
     * Добавление условия BETWEEN
     * @param string $field
     * @param string $first
     * @param string $second
     * @return SQLQueryBuilder
     */
    public function whereBetween(string $field, string $first, string $second): SQLQueryBuilder;

    /**
     * Добавление ограничения LIMIT.
     * @param int $limit
     * @return SQLQueryBuilder
     * @throws \Exception
     */
    public function limit(int $limit): SQLQueryBuilder;

    /**
     * Добавление ограничения OFFSET.
     * @param int $offset
     * @return $this
     * @throws \Exception
     */
    public function offset(int $offset);

    /**
     * Получение окончательной строки запроса.
     */
    public function getQuery(): string;

    /**
     * Добавление условия GROUP BY
     * @param string $field
     * @return mixed
     */
    public function groupBy(string $field);

    /**
     * Возвращает результат строки запроса.
     * @return array
     */
    public function getResult();

    /**
     * Возвращает результат запроса
     * @return mixed
     */
    public function getArrayResult();
}
