<?php

require "Header.php";
require "MySQL.php";


$headers = array();
$headersQuery = $connect->query("SELECT * FROM `headers` ORDER BY `name` ASC");
while ($row = $headersQuery->fetch_assoc()) {
    $header = new Header($row['name']);
    $headers[count($headers)] = $header;
}
$typeQuery = $connect->query("SELECT * FROM `types` ORDER BY `header` ASC");
$types = array();
while ($type = $typeQuery->fetch_assoc()) {
    $header = null;
    for ($i = 0; $i < count($headers); $i++) {
        if ($type['header'] == $headers[$i]->name)
            $header = $headers[$i];
    }
    if ($header != null)
        $types[count($types)] = new Type($header, $type['name'], new Params(""));
    else {
        echo "Произошла ошибка";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
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
        <a class="navbar-brand" href="https://local.api.devdem.ru/apps/teh-line-configurator/">Технолайн
            конфигуратор</a>
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
                    for ($k = 0; $k < count($types); $k++) {
                        if ($types[$k]->header->name == $headers[$i]->name) {
                            echo "<option value='" . $k . "'>" . $types[$k]->name . "</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>

        <?php
        for ($i = 0; $i < count($types); $i++) {
            echo "<div class=\"mb-3\" id=\"" . $i . "\" style=\"display: " . ($i == 0 ? "block" : "none") . "\">";
            echo "<label for=\"customRange1\" class=\"form-label\">" . $types[$i]->name . "</label>";
            echo "</div>";
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

<?php
$connect->close(); ?>
</body>
</html>