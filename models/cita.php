<?php
namespace Models;
class cita extends ActiveRecord{


    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora','usuariold'];

    public $id;
    public $fecha;
    public $hora;
    public $usuariold;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuariold = $args['usuariold'] ?? '';
    }


}