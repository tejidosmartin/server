<?php
require_once("Producto.php");

class BbDd
{
    private static PDO $conexion;

    public static function consulta(string $sql)
    {
        try {
            [$host, $user, $pwd, $db] = ["localhost", "shakar", "tWbh0H#ov#RG4AJ%v", "tienda"];
            self::$conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pwd);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (strpos(strtoupper(trim($sql)), "SELECT") >= 0) {
                $resultado = self::$conexion->query($sql);
            } else {
                $resultado = self::$conexion->exec($sql);
            }
            if ($resultado == null) {
                echo "Error en la consulta: $sql";
                exit(2);
            }
            return $resultado;
        } catch (PDOException $exception) {
            exit("<br/>Error: " . $exception->getMessage() . "<br/>");
        }
    }

    /**
     * Funcion encargada de devolver una pelicula
     * dependiendo del id que se le pase por parametro
     *
     * @param integer $id recibe el id de la pelicula a consultar
     * @return void
     */
    public static function devolverArticulo(int $codigo)
    {
        $sql = "select * from producto where codigo=$codigo";
        $resultado = self::consulta($sql);
        while ($articulo = $resultado->fetch(PDO::FETCH_ASSOC)) {
            return self::convertirAObjeto($articulo);
        }
    }

    /**
     * Funcion encargada de hacer un listado de perliculas
     *
     * @param integer $numPag recibe un numero de pagina
     * @param integer $tamPag recibe el tamaño de pagina
     * @return array devulve un array con el resultado
     */
    public static function listaPeliculas(int $numPag = 1, int $tamPag = 10): array
    {
        $comienzo = ($numPag - 1) * $tamPag;
        $resultado = self::consulta("Select * from producto limit $comienzo, $tamPag");
        $listaProductos = [];
        while ($p = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $listaProductos[] = $p;
        }
        return $listaProductos;
    }

    public static function all()
    {
        $sql = "Select * from producto";
        $resultado = self::consulta($sql);
        return $resultado;
    }

    /**
     * Funcion encargada de convertir una rray a objetop
     *
     * @param [type] $array recibe el array a trata
     * @return void
     */
    public static function convertirAObjeto($array)
    {
        $codigo = $array['codigo'];
        $familia = $array['familia'];
        $serie = $array['serie'];
        $modelo = $array['modelo'];
        $proveedor = $array['proveedor'];
        $ufc = $array['ufc'];
        $ufv = $array['ufv'];
        $color = $array['color'];
        $talla = $array['talla'];

        return $articulo = new Producto($codigo, $familia, $serie, $modelo, $proveedor, $ufc, $ufv, $color, $talla);
    }
}
