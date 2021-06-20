<?php

require "Type.php";
require "Params.php";
require "Param.php";

class Header
{
    public string $name;
    public array $types;

    function __construct(string $name, array $types)
    {
        $this->name = $name;
        $this->types = $types;
    }
}
