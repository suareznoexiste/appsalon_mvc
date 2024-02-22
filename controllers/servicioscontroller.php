<?php

namespace Controllers;

use MVC\Router;
use Models\servicios;

class ServiciosController
{
    public static function index(Router $router)
    {
        @session_start();
        isAdmin();
        $servicios = servicios::all();
        $nombre = $_SESSION['nombre'];
        $router->render('servicios/index', [
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router)
    { @session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];
        $alertas = [];
        $servicios = new servicios;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicios->sincronizar($_POST);
            $alertas = $servicios->validar();
            if (empty($alertas)) {
                $servicios->guardar();
                header('location: /servicios');
            }
        }
        $router->render('servicios/crear', [
            'nombre' => $nombre,
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }
    public static function actualizar(Router $router)
    {  @session_start();
        isAdmin();
        $alertas = [];
        $nombre = $_SESSION['nombre'];
        $id = $_GET['id'];
        if (!is_numeric($_GET['id'])) return;
        $servicios = servicios::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicios->sincronizar($_POST);
            $alertas = $servicios->validar();
            if (empty($errores)) {
                $servicios->guardar();
                header('location:/admin');
            }
        }


        $router->render('servicios/actualizar', [
            'nombre' => $nombre,
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }
    public static function eliminar()
    { @session_start();
        isAdmin();

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $servicios = servicios::find($id);

            $servicios->eliminar();
            header('location:/servicios');
        }
    }
}
