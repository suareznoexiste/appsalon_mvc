<?php

namespace Controllers;


use MVC\Router;


class CitaController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        $nombre = $_SESSION['nombre'];
        $id = $_SESSION['usuario'];

        $router->render('citas/index', [
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
    public static function crear(Router $router)
    {
        $router->render('citas/crear');
    }
    public static function editar(Router $router)
    {
        $router->render('citas/editar');
    }
    public static function eliminar(Router $router)
    {
        $router->render('citas/eliminar');
    }
}
