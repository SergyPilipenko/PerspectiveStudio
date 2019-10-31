<?php


namespace Partfix\QueryBuilder\Contracts;


interface SQLQueryBuilder
{
    public function select(string $table, array $fields): SQLQueryBuilder;

    public function join(string $table, string $first, string $second): SQLQueryBuilder;

    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder;

    public function whereBetween(string $field, string $first, string $second): SQLQueryBuilder;

    public function limit(int $limit): SQLQueryBuilder;

    public function getQuery(): string;


}
