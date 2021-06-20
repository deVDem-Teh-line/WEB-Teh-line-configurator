<?php


class Type
{
    public Header $header;
    public string $name;
    public Params $params;

    function __construct(Header $header, string $name, Params $params)
    {
        $this->name = $name;
        $this->header = $header;
        $this->params = $params;
    }
}