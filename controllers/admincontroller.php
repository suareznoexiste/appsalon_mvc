<?php

namespace Controllers;

use Models\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }




        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuariold=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citas_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicios_id ";
        $consulta .= " WHERE fecha =  '$fecha' ";





        $citas = AdminCita::SQL($consulta);

        $nombre = $_SESSION['nombre'];
        $router->render('admin/index', [
            'nombre' => $nombre,
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
