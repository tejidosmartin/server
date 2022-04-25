<?php
    include_once "../model/BbDd.php";
    include_once "../model/Producto.php";

    $action = $_GET["action"];

    if ($action == "list") {
        header("Access-Control-Allow-Origin: http://localhost:4200");
        $sentencia = BbDd::all();
        $mascotas = $sentencia->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($mascotas);
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
?>