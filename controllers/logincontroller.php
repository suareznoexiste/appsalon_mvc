<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Models\Usuario;

class LoginController
{
    public  static function login(Router  $router)
    {

        $alertas = [];
        $auth = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            //validamos el formulario
            $alertas = $auth->validarLogin();
            //comprobamos si el usuario existe
            $usuario = Usuario::where('email', $auth->email);

            //y si existe comprobamos si la contraseña es correcta
            if ($usuario) {
                if ($usuario->comprobarPasswordVerificado($auth->password)) {

                    session_start();
                    //en vez de  el nombre der usarui deberia ser id pero yo soy loco jaja
                    $_SESSION['usuario'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $_SESSION['apellido'];
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;


                    if ($usuario->admin === '1') {
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    } else {
                        header('Location: /citas');
                    }
                }
            } else {
                Usuario::setAlerta('error', 'El usuario no existe');
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [

            'alertas' => $alertas,
            'auth' => $auth ?? ''

        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();
            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado) {

                    $usuario->creartoken();
                    $usuario->guardar();



                    //?: enviar email con el token
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarIntrucciones();


                    Usuario::setAlerta('exito', 'Revisa tu email para cambiar tu contraseña');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
                $alertas = Usuario::getAlertas();
            }
        }

        // * aqui empieza el render
        $router->render(
            'auth/olvide',
            [
                'alertas' => $alertas
            ]
        );
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $flagError = false;
        //  aqui lo estamos sanitazando con la funcion s
        $token = s($_GET['token']);
        //buscar usuario con el token
        $usuario = Usuario::where('token', $token);


        if (!$usuario) {
            Usuario::setAlerta('error', 'Token no valido');
            $flagError = true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if (empty($password)) {

                // aqui para medio borrar la contraseña
                $usuario->password = null;
                $usuario->password = $password->password;
                //ya tiene la instancia del objeto
                $usuario->hashPassword();
                //volvemos a poner el token en null
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [

            'alertas' => $alertas, 'flag'  => $flagError
        ]);
    }

    public static function crear(Router $router)
    {
        // lo hacemos aqui por que queremos que el formulario se llene automticamente
        $usuario = new Usuario();

        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //aquí se sincroniza el objeto usuario con los datos del formulario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {

                $resultado = $usuario->existeUsuario();
                //aqui lo volvemos a comprobar

                if ($resultado->num_rows) {
                    //lo que ya hicimos en el metodo  existe usuario aqui lo volvemos a hacer y como ya paso la alerta
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();
                    $usuario->creartoken();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    //crear usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        //redireccionar
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [


            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function confirmar(Router $router)
    {
        $alertas = [];
        //atraemos el token de la url
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('danger', 'Token no valido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada');
        }

        $alertas = Usuario::getAlertas();

        $router->render(
            'auth/confirmar-cuenta',
            [
                'alertas' => $alertas
            ]

        );
    }
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }
}
