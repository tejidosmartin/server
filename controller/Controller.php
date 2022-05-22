<?php
error_reporting(E_ALL ^ E_WARNING);

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$idSesion = "";

if (isset($_COOKIE["PHPSESSID"])) {
    $idSesion = printf($_COOKIE["PHPSESSID"]);
} else {
    startSessionIfNotExist();
}
$idSesion = printf($_COOKIE["PHPSESSID"]);

if (isset($_GET["action"]) && !empty($_GET["action"]) && empty($_GET["filter"])) {
    if ($_GET["action"] == "list") {
        header("Access-Control-Allow-Origin: *");
        $sentencia = BbDd::listaProductos(1, 9);
        echo json_encode($sentencia);
    }
}
if (empty($_GET["action"]) && !empty($_GET["filter"])) {
    header("Access-Control-Allow-Origin: *");
    $sentencia = BbDd::filterBy($filter);
    echo json_encode($sentencia);
}
if (!empty($_GET["codigo"])) {
    header("Access-Control-Allow-Origin: *");
    $sentencia = BbDd::devolverArticulo($_GET["codigo"]);
    echo json_encode($sentencia);
}
