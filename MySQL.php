<?php

$credinals = json_decode(file_get_contents("D:\Sites\credinals.json"), true);
$connect = mysqli_connect(
    $credinals["mySQL"]["host"],
    $credinals["mySQL"]["account"][1]["user"],
    $credinals["mySQL"]["account"][1]["password"],
    "teh-line-configurator",
    $credinals["mySQL"]["port"]);
$connect->query("SET NAMES `utf8`");