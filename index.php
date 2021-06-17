<?php

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

$credinals = json_decode(file_get_contents("D:\Sites\credinals.json"), true);
$connect = mysqli_connect(
    $credinals["mySQL"]["host"],
    $credinals["mySQL"]["account"][1]["user"],
    $credinals["mySQL"]["account"][1]["password"],
    "teh-line-configurator",
    $credinals["mySQL"]["port"]);
$connect->query("SET NAMES `utf8`");
$headers = array();
$headersQuery = $connect->query("SELECT * FROM `headers`  ORDER BY `id` ASC");
while ($row = $headersQuery->fetch_assoc()) {
    $header = new Header($row['name'], array());
    $typeQuery = $connect->query("SELECT * FROM `types` WHERE `header` = \"" . $row['id'] . "\"  ORDER BY `id` ASC");
    $types = array();
    while ($type = $typeQuery->fetch_assoc()) {
        $types[count($types)] = new Type($type['id'], $header, $type['name'], new Params(""));
    }
    $header->types = $types;
    $headers[count($headers)] = $header;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Технолайн конфигуратор</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<script> const debug = true;</script>
<body class="bg-secondary">
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Технолайн конфигуратор</a>
    </div>
</nav>
<br>
<div class="container bg-light" style="border-radius: 5px">
    <h1>Поиск станка</h1>
    <form>
        <legend class="text-secondary">Выберите необходимые настройки</legend>
        <div class="mb-3 mt-3">
            <label for="type" class="form-label">Тип станка</label>
            <select id="type" name="type" class="form-select">
                <?php
                for ($i = 0; $i < count($headers); $i++) {
                    echo "<optgroup label=\"" . $headers[$i]->name . "\"></optgroup>";
                    for ($j = 0; $j < count($headers[$i]->types); $j++) {
                        echo "<option value='".$headers[$i]->types[$j]->id."'>" . $headers[$i]->types[$j]->name . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <?php
        for ($i = 0; $i < count($headers); $i++) {
            for ($j = 0; $j < count($headers[$i]->types); $j++) {
                echo "<div class=\"mb-3\" id=\"" . $headers[$i]->types[$j]->name . "\" style=\"display: ".($i==0 && $j==0 ? "block" : "none")."\">";
                echo "<label for=\"customRange1\" class=\"form-label\">" . $headers[$i]->types[$j]->name . "</label>";
                echo "</div>";
            }
        }

        ?>
        <div class="mb-3">
            <button class="btn btn-primary" onclick="goSearch()">Поиск</button>
        </div>
    </form>
    <br>
</div>
<script>
    if (debug) setTimeout(function () {
        location.reload();
    }, 30000);
    let selectElem = document.getElementById('type');
    selectElem.addEventListener("change", function () {
        for (let i = 0; i < this.options.length; i++) {
            try {
                document.getElementById(this.options[i].value).style.display = 'none';
            } catch (e) {
                if (debug) console.log(e);
            }
        }
        try {
            document.getElementById(this.value).style.display = 'block';
        } catch (e) {
            if (debug) console.log(e);
        }
    });
    function updateUI() {
        for (let i = 0; i < selectElem.options.length; i++) {
            try {
                document.getElementById(selectElem.options[i].value).style.display = 'none';
            } catch (e) {
                if (debug) console.log(e);
            }
        }
        try {
            document.getElementById(selectElem.value).style.display = 'block';
        } catch (e) {
            if (debug) console.log(e);
        }
    }
    function goSearch() {
        if (selectElem.selectedIndex === 0) {
            console.log("Nothing");
        } else {
            console.log("SEARCH!");
        }
    }
</script>
</body>
</html>