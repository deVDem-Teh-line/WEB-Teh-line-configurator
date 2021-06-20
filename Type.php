<?php


class Type
{
    public int $id;
    public Header $header;
    public string $name;
    public Params $params;

    function __construct(int $id, Header $header, string $name, Params $params)
    {
        $this->id = $id;
        $this->name = $name;
        $this->header = $header;
        $this->params = $params;
    }
}