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
        <a class="navbar-brand" href="https://local.api.devdem.ru/apps/teh-line-configurator/">Технолайн конфигуратор - Админ панель</a>
    </div>
</nav>
<br>
<div class="container bg-light" style="border-radius: 5px">
    <?php
    // @noinspection ALL
    require "Header.php";
    require "MySQL.php";

    // GET SETTINGS FROM MYSQL
    $sql = $connect->query("SELECT * FROM `settings`");
    $settings = array();
    while ($row = $sql->fetch_assoc()) {
        $settings[$row['name']] = $row['arg'];
    }

    $pwds = false;
    // CHECK POST PASS
    if (isset($_POST['pwd']) && $_POST['pwd'] == $settings['admPass']) {
        setcookie("pwd", $_POST['pwd'], time() + 3600);
        $pwds = true;
    }
    // CHECK COOKIES
    if ((isset($_COOKIE["pwd"]) && $_COOKIE["pwd"] == $settings['admPass']) || $pwds) {
        if (isset($_POST["pwd"])) {
            header("Location: https://local.api.devdem.ru/apps/teh-line-configurator/admin.php");
        }

        switch ($_GET['menu']) {
            case 1: {
                $headers = array();
                $headersQuery = $connect->query("SELECT * FROM `headers` ORDER BY `name` ASC");
                while ($row = $headersQuery->fetch_assoc()) {
                    $header = new Header($row['name']);
                    $headers[count($headers)] = $header;
                }



                break;
            }

            default:
        ?>

            <h1 class="text-primary">Админ панель</h1>
            <h4 class="text-black-50">Выберите действие</h4>
            <div class="d-grid gap-1 mb-2">
                <button class="btn btn-outline-primary mb-1" onclick="goMenu(1)">Список заголовков машин</button>
                <button class="btn btn-outline-primary mb-1" onclick="goMenu(2)">Список типов машин</button>
                <button class="btn btn-outline-primary mb-1" onclick="goMenu(3)">Список машин</button>
                <button class="btn btn-outline-primary mb-1" onclick="goMenu(4)">Настройки сайта</button>
                <button class="btn btn-outline-danger mb-1" onclick="signOut()">Выйти из панели</button>
            </div>
        <?php
        }
        } else {
        ?>
        <form action="admin.php" method="post" class="row g-3 ps-3 pe-3">
            <h1>Требуется пароль для входа</h1>
            <input placeholder="Введите пароль" type="password" name="pwd">
            <button type="submit" class="form-control btn btn-primary">Вход</button>
        </form> <br/>
        <?php
    }


    $connect->close();
    ?>

    <script>

        function goMenu(i) {
            $url = "https://local.api.devdem.ru/apps/teh-line-configurator/admin.php?menu=" + i;
            document.location.href = $url;
        }

        function signOut() {
            var result = confirm("Вы уверены?");
            if(result) {
                var cookie_date = new Date();  // Текущая дата и время
                cookie_date.setTime(cookie_date.getTime() - 1);
                document.cookie = "pwd=; expires=" + cookie_date.toGMTString();
                location.reload();
            }
        }

    </script>
</div>
</body>
</html>