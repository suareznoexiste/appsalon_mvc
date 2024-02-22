<?php

namespace Models;

class Citaservicios extends ActiveRecord
{

    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'citas_id', 'servicios_id'];

    public $id;
    public $citas_id;
    public $servicios_id;


    public  function __construct($arg = [])
    {
        $this->id = $arg['id'] ?? null;
        $this->citas_id = $arg['citas_id'] ?? '';
        $this->servicios_id = $arg['servicios_id'] ?? '';
    }
}
