<?php

require "Header.php";

$pwds = false;
if (isset($_POST['pwd']) && $_POST['pwd'] == "123456") {
    setcookie("pwd", $_POST['pwd'], time() + 3600);
    $pwds = true;
}

if ((isset($_COOKIE["pwd"]) && $_COOKIE["pwd"] == "123456") || $pwds) {
    require "MySQL.php";
} else {
    ?>
    <form action="admin.php" method="post">
        <input placeholder="Введите пароль" type="password" name="pwd">
        <input type="submit">
    </form>
    <?php
} ?>
