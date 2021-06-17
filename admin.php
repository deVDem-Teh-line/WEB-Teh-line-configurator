<?php /** @noinspection DuplicatedCode */

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

class Params
{
    public array $params;
    function __construct(string $params)
    {
        //$this->params = json_decode($params);
    }
}

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

$pwds = false;
if (isset($_POST['pwd']) && $_POST['pwd'] == "123456") {
    setcookie("pwd", $_POST['pwd'], time() + 3600);
    $pwds = true;
}

if ((isset($_COOKIE["pwd"]) && $_COOKIE["pwd"] == "123456") || $pwds) {
    $credinals = json_decode(file_get_contents("D:\Sites\credinals.json"), true);
    $connect = mysqli_connect(
        $credinals["mySQL"]["host"],
        $credinals["mySQL"]["account"][1]["user"],
        $credinals["mySQL"]["account"][1]["password"],
        "teh-line-configurator",
        $credinals["mySQL"]["port"]);
    $connect->query("SET NAMES `utf8`");
} else {
    ?>
    <form action="admin.php" method="post">
        <input placeholder="Введите пароль" type="password" name="pwd">
        <input type="submit">
    </form>
    <?php
} ?>
