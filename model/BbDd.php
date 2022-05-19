<?php
error_reporting(E_ALL ^ E_WARNING);
require_once("Producto.php");
require_once("../utils/functions.php");

class BbDd
{
    private static PDO $conexion;

    /**
     * Función de conexión y consulta
     *
     * @param  mixed $sql recibe un string con la consulta
     * @return mixed
     */
    public static function consulta(string $sql)
    {
        try {
            [$server, $username, $password, $db] = ["localhost", "shakar", "tWbh0H#ov#RG4AJ%v", "tienda"];
            /* $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

            $server = $url["host"];
            $username = $url["user"];
            $password = $url["pass"];
            $db = substr($url["path"], 1); */

            self::$conexion = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $username, $password);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            if (strpos(strtoupper(trim($sql)), "SELECT") >= 0) {
                $resultado = self::$conexion->prepare($sql);
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

    public static function obtenerConexion()
    {
        $password = "tWbh0H#ov#RG4AJ%v";
        $user = "shakar";
        $dbName = "tienda";
        $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
        $database->query("set names utf8;");
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $database;
    }

    /**
     * Funcion encargada de devolver un producto
     * dependiendo del id que se le pase por parametro
     *
     * @param integer $id recibe el id del producto a consultar
     * @return object Producto
     */
    public static function devolverArticulo(string $codigo)
    {
        $sql = "select * from `producto` where id=?";
        $resultado = self::consulta($sql);
        $resultado->execute([$codigo]);
        while ($articulo = $resultado->fetch(PDO::FETCH_ASSOC)) {
            return $articulo;
        }
    }

    /**
     * Funcion encargada de devolver los productos que se
     * encuentran en el carrito a partir del id de 
     * sesion
     *
     * @return mixed
     */
    public static function obtenerProductosCarrito($idSesion)
    {
        $sql = "SELECT producto.id, producto.familia, producto.serie,
        producto.modelo, producto.color, producto.talla, producto.nombre, 
        producto.descripcion, producto.precio FROM producto
        INNER JOIN carrito_usuarios ON producto.id = carrito_usuarios.id
        WHERE carrito_usuarios.id_sesion = ?";

        $sentencia = self::consulta($sql);

        $sentencia->execute([$idSesion]);
        $listaProductos = [];
        while ($p = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $listaProductos[] = $p;
        }

        return $listaProductos;
    }

    /**
     * Funcion encargada de hacer un listado de productos
     *
     * @param integer $numPag recibe un numero de pagina
     * @param integer $tamPag recibe el tamaño de pagina
     * @return mixed 
     */
    public static function listaProductos(int $numPag = 1, int $tamPag = 10): mixed
    {
        $comienzo = ($numPag - 1) * $tamPag;
        $sentencia = self::consulta("select * from producto limit ?, ?");
        $sentencia->execute([$comienzo, $tamPag]);
        $listaProductos = [];
        while ($p = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $listaProductos[] = $p;
        }
        return $listaProductos;
    }


    /**
     * Función encargada de agregar un producto al carrito
     * a partir de la id del producto
     *
     * @param mixed $idProducto recibe el id del producto
     * @return mixed
     */
    public static function agregarProductoCarrito($idProducto, $idSesion)
    {
        $sql = "INSERT INTO carrito_usuarios(id_sesion, id) VALUES (?, ?)";
        $sentencia = self::consulta($sql);


        return $sentencia->execute([$idSesion, $idProducto]);

    }

    public static function quitarProductoCarrito($idProducto, $idSesion )
    {
        $sql = "DELETE FROM carrito_usuarios WHERE id_sesion = ? AND id = ?";
        $sentencia = self::consulta($sql); 

        return $sentencia->execute([$idSesion, $idProducto]);
    }

    public static function obtenerIdsProductoCarrito()
    {
        $sql = "SELECT id FROM carrito_usuarios WHERE id_sesion = ?";
        $sentencia = self::consulta($sql);

        $idSesion = "";

        if (isset($_COOKIE["PHPSESSID"])) {
            $idSesion = printf($_COOKIE["PHPSESSID"]);
        } else{
            startSessionIfNotExist();           
        }
        $idSesion = printf($_COOKIE["PHPSESSID"]);

        $sentencia->execute([$idSesion]);
        return $sentencia->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function filterBy(/* string $filtro, */string $value, int $numPag = 1, int $tamPag = 10)
    {
        $comienzo = ($numPag - 1) * $tamPag;
        $resultado = self::consulta("select * from producto where familia='$value' limit $comienzo, $tamPag");
        $listaProductos = [];
        while ($p = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $listaProductos[] = $p;
        }
        return $listaProductos;
    }

    public static function all()
    {
        $sql = "select * from producto";
        $resultado = self::consulta($sql);
        return $resultado;
    }

    /**
     * Funcion encargada de convertir una rray a objetop
     *
     * @param array $array recibe el array a trata
     * @return object
     */
    public static function convertirAObjeto($array)
    {
        $id = $array['id'];
        $familia = $array['familia'];
        $serie = $array['serie'];
        $modelo = $array['modelo'];
        $color = $array['color'];
        $talla = $array['talla'];
        $nombre = $array['nombre'];
        $descripcion = $array['descripcion'];
        $precio = $array['precio'];

        $articulo = new Producto($id, $familia, $serie, $modelo, $color, $talla, $nombre, $descripcion, $precio);
        return $articulo;
    }

    public static function is_session_started()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }
}
