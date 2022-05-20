<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$json = file_get_contents('php://input');

$params = json_decode($json);

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

if (BbDd::quitarProductoCarrito($params->id, $idSesion)) {
    $response = new Result();
    $response->ok = 'true';
    $response->mensaje = 'producto añadido al carrito';
} else {
    $response = new Result();
    $response->ok = 'false';
    $response->mensaje = 'a ocurrido un error';
}


header('Content-Type: application/json');
echo json_encode($response);
