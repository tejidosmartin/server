<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once("../model/BbDd.php");
include_once("../model/Producto.php");
include_once("../utils/functions.php");

$json = file_get_contents('php://input');

$params = json_decode($json);
if (is_session_started() === FALSE) session_start();
$idSesion = session_id();

BbDd::agregarProductoCarrito($params->id, $idSesion);

class Result{}

$response = new Result();
$response->resultado = 'OK';
$response->mensaje = 'datos grabados';

header('Content-Type: application/json');
echo json_encode($response);
