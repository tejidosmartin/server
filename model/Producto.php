<?php

class Producto
{
    private array $atributos = [];

    public function __construct(string $id, string $familia, string $serie, string $modelo, string $color, string $talla, string $nombre, string $descripcion, int $precio)
    {
        $this->atributos['id'] = $id;
        $this->atributos['familia'] = $familia;
        $this->atributos['serie'] = $serie;
        $this->atributos['modelo'] = $modelo;
        $this->atributos['color'] = $color;
        $this->atributos['talla'] = $talla;
        $this->atributos['nombre'] = $nombre;
        $this->atributos['descripcion'] = $descripcion;
        $this->atributos['precio'] = $precio;
    }

    /**
     * Funcion que devulve un atributo
     *
     * @param string $atributo atributo a devolver
     * @return void
     */
    public function __get(string $atributo)
    {
        return $this->atributos[$atributo];
    }

    /**
     * Funcion encargada de pasar un atributo
     *
     * @param string $atributo a pasar
     * @param [type] $valor valor a asignar
     */
    public function __set(string $atributo, $valor)
    {
        $this->atributos[$atributo] = $valor;
    }

    /**
     * Funcion que devulve los atributos
     *
     * @return void
     */
    public function getAtributos()
    {
        return $this->atributos;
    }
}
