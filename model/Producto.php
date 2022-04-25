<?php

class Producto
{
    private array $atributos = [];

    public function __construct(int $codigo, string $familia, string $serie, string $modelo, int $proveedor, string $ufc, string $ufv, string $color, string $talla)
    {
        $this->atributos['codigo'] = $codigo;
        $this->atributos['familia'] = $familia;
        $this->atributos['serie'] = $serie;
        $this->atributos['modelo'] = $modelo;
        $this->atributos['proveedor'] = $proveedor;
        $this->atributos['ufc'] = $ufc;
        $this->atributos['ufv'] = $ufv;
        $this->atributos['color'] = $color;
        $this->atributos['talla'] = $talla;
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
