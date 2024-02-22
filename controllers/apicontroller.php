<?php

namespace Controllers;

use Models\servicios;
use Models\cita;
use Models\Citaservicios;

class ApiController
{
    public static function index()
    {
        $servicios = servicios::all();
        echo json_encode($servicios);
    }
    public  static function guardar()
    {
        //almacenamos los datos de la cita
        $cita  = new cita($_POST);
        $resultado = $cita->guardar();

    
        //este $resultado ['id'] lo devuelve active record al ingresar la cita
        $id = $resultado['id'];

          //del post extraemos los id de  los servicios y los almacenamos en un array
        $idServicios = explode(',', $_POST['serviciosId']);
        //el que recorremos aca
        foreach ($idServicios as $idServicio) {
            $arg = [
                'citas_id' => $id,
                'servicios_id' => $idServicio
            ];
            //enviamos los argumentos a citas servicios donde se ingresan los datos de citaservicio
            $citaservicio = new Citaservicios($arg);
            $citaservicio->guardar();
        }

        $respuesta = [
            'servicios' => $resultado,

        ];
        echo json_encode($respuesta);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $cita =  cita::find($id);
                $cita->eliminar();
                //? aqui se redirecciona a la pagina anterior
                header('Location:'.$_SERVER['HTTP_REFERER']);
                $respuesta = [
                    'id' => $id
                ];
                echo json_encode($respuesta);
            }
        }
    }
}
