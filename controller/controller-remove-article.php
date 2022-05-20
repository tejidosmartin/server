<?php
header('Access-Control-Allow-Origin: http://tejidosmartin.herokuapp.com, http://localhost:4200');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Access-Control-Allow-Methods: GET, POST, DELETE');

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$id = $_GET["id"];

$idSesion = "";

if (isset($_COOKIE["PHPSESSID"])) {
    $idSesion = printf($_COOKIE["PHPSESSID"]);
} else {
    startSessionIfNotExist();
    $idSesion = printf($_COOKIE["PHPSESSID"]);
}

class Result
{
}

if (BbDd::quitarProductoCarrito($id, $idSesion)) {
    $response = new Result();
    $response->ok = 'true';
    $response->mensaje = 'producto eliminado';
} else {
    $response = new Result();
    $response->ok = 'false';
    $response->mensaje = 'a ocurrido un error';
}

header('Content-Type: application/json');
echo json_encode($response);
