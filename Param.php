<?php


class Param {
    public string $label;
    public int $type; // 0 - checkbox, 1 - range, 2 - input
    public float $minValue;
    public float $maxValue;
    public array $options;

    function __construct(string $label)
    {

    }
}