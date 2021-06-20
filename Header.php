<?php

require "Type.php";
require "Params.php";
require "Param.php";

class Header
{
    public string $name;

    function __construct(string $name)
    {
        $this->name = $name;
    }
}
