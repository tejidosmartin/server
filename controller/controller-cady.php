<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$idSesion = "";

if (isset($_COOKIE["PHPSESSID"])) {
    $idSesion = printf($_COOKIE["PHPSESSID"]);
} else {
    startSessionIfNotExist();
    $idSesion = printf($_COOKIE["PHPSESSID"]);
}

$sentencia = BbDd::obtenerProductosCarrito($idSesion);
echo json_encode($sentencia);


?>