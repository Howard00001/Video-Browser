<?php
include "mygenerate.php";
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    @$route = $_POST["route"];
    @$watched = $_POST["watched"];
    @$rate = $_POST["rate"];
    @$addtags = $_POST["addtags"];
    @$addauthers = $_POST["addauthers"];

    $tosync = new treasure($route);
    $tosync->watched = $watched;
    $tosync->rate = $rate;
    upsync($tosync);
}
?>