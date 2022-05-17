<?php
error_reporting(E_ALL ^ E_WARNING);
include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$action = $_GET["action"];
$filter = $_GET["filter"];
$codigo = $_GET["codigo"];

if (isset($_GET["action"]) && !empty($action) && empty($filter)) {
    if ($action == "carrito") {
        header("Access-Control-Allow-Origin: *");
        $sentencia = BbDd::obtenerProductosCarrito();
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


/* header("Access-Control-Allow-Origin: http://localhost:4200");
    if (empty($_GET["codigo"])) {
        exit("No hay codigo de articulo");
    }
    $codigo = $_GET["codigo"];
    $bd = include_once "../model/BbDd.php";
    $sentencia = $bd->devolverArticulo($codigo);

    $articulo = $sentencia->fetchObject();
    echo json_encode($articulo); */

/* $a = obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
echo $a;

BbDd::agregarProductoCarrito("A2K9X0S8S9");

BbDd::obtenerIdsProductoCarrito(); */
