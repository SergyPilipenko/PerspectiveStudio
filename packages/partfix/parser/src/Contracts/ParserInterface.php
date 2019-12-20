<?php


namespace Partfix\Parser\Contracts;


interface ParserInterface
{
    public function csv($file, ?string $delimiter = ',') : ParserInterface;

    public function limit(int $limit) : ParserInterface;

    public function alphabetical() : ParserInterface;

    public function getItems() : array;

    public function getMaxRowLength() : int;

    public function chunk(int $length, callable $callback);
}
