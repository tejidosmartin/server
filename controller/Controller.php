<?php
error_reporting(E_ALL ^ E_WARNING);

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$action = $_GET["action"];
$filter = isset($_GET["filter"]);
$codigo = isset($_GET["codigo"]);

$idSesion = "";

if (isset($_COOKIE["PHPSESSID"])) {
    $idSesion = printf($_COOKIE["PHPSESSID"]);
} else {
    startSessionIfNotExist();
}
$idSesion = printf($_COOKIE["PHPSESSID"]);

if (isset($_GET["action"]) && !empty($action) && empty($filter)) {
    if ($action == "carrito") {
        /* header("Access-Control-Allow-Origin: *"); */
        $sentencia = BbDd::obtenerProductosCarrito($idSesion);
        echo json_encode($sentencia);
    }
    if ($action == "list") {
        header("Access-Control-Allow-Origin: *");
        $sentencia = BbDd::listaProductos(1, 9);
        echo json_encode($sentencia);
    }
}
if (empty($action) && !empty($filter)) {
    header("Access-Control-Allow-Origin: *");
    $sentencia = BbDd::filterBy($filter);
    echo json_encode($sentencia);
}
if (!empty($codigo)) {
    header("Access-Control-Allow-Origin: *");
    $sentencia = BbDd::devolverArticulo($codigo);
    echo json_encode($sentencia);
}
