<?php

namespace Models;

class servicios  extends ActiveRecord
{


    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public  function __construct($arg = [])
    {
        $this->id = $arg['id'] ?? null;
        $this->nombre = $arg['nombre'] ?? '';
        $this->precio = $arg['precio'] ?? 0;
    }
    public function validar()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = "nombre es obligatorio";
        }
        if (!$this->precio) {
            self::$alertas['error'][] = "precio es obligatorio";
        }
        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = "solo se aceptan numeros";
        }

        return self::$alertas;
    }
}
