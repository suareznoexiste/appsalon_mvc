<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\ServiciosController;
use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\LoginController;
use Controllers\CitaController;
use MVC\Router;

$router = new Router();

//?iniciar sesion rutas
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//?olvide mi contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//?crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//?confirmr cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->post('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);



//?areaprivada

$router->get('/citas', [CitaController::class, 'index']);
$router->get('/citas/crear', [CitaController::class, 'crear']);
$router->post('/citas/crear', [CitaController::class, 'crear']);
$router->get('/citas/editar', [CitaController::class, 'editar']);
$router->post('/citas/editar', [CitaController::class, 'editar']);
$router->get('/citas/eliminar', [CitaController::class, 'eliminar']);
$router->post('/citas/eliminar', [CitaController::class, 'eliminar']);

//?areaprivad con admin
$router->get('/admin', [AdminController::class, 'index']);

//?rutas de api
$router->get('/api/servicios', [ApiController::class, 'index']);
$router->post('/api/citas', [ApiController::class, 'guardar']);
$router->post('/api/eliminar', [ApiController::class, 'eliminar']);

//?crud de servicios
$router->get('/servicios', [ServiciosController::class, 'index']);
$router->get('/servicios/crear', [ServiciosController::class, 'crear']);
$router->post('/servicios/crear', [ServiciosController::class, 'crear']);
$router->get('/servicios/actualizar', [ServiciosController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServiciosController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServiciosController::class, 'eliminar']);



// ?comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
