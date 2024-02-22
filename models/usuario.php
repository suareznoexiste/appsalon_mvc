<?php

namespace Models;

class usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];


    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;


    public function __construct($arg = [])
    {
        $this->id = $arg['id'] ?? null;
        $this->nombre = $arg['nombre'] ?? '';
        $this->apellido = $arg['apellido'] ?? '';
        $this->email = $arg['email'] ?? '';
        $this->password = $arg['password'] ?? '';
        $this->telefono = $arg['telefono'] ?? '';
        $this->admin = $arg['admin'] ?? 0;
        $this->confirmado = $arg['confirmado'] ?? 0;
        $this->token = $arg['token'] ?? '';
    }
    //! validaciones
    public function validarPassword(){
        
        if (!$this->password) {
            self::$alertas['error'][] = "El password es obligatorio";
        }
        if (strlen($this->password)<6) {
            self::$alertas['error'][] = "El password tiene que se mayor a 6 caracteres";
        }
        return self::$alertas;

    }


    public function validarEmail()
    {

        if (!$this->email) {
            self::$alertas['error'][] = "El email es obligatorio";
        }
        return self::$alertas;
    }
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "El password es obligatorio";
        }
        return self::$alertas;
    }

    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            static::$alertas['error'][] = "Debes añadir tu nombre";
        }
        if (!$this->apellido) {
            static::$alertas['error'][] = "Debes añadir tu apellido";
        }
        if (!$this->email) {
            static::$alertas['error'][] = "Debes añadir tu email";
        }
        if (!$this->password) {
            static::$alertas['error'][] = "Debes añadir tu password";
        }
        if (strlen($this->password) < 6) {
            static::$alertas['error'][] = "El password debe tener al menos 6 caracteres";
        }
        if (!$this->telefono) {
            static::$alertas['error'][] = "Debes añadir tu telefono";
        }
        return self::$alertas;
    }

    public function existeUsuario()
    {
        $query = "SELECT * FROM " . static::$tabla . "  WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        //el num arrows nos dice cuantos registros hay por lo que si hay mas de 0 es que ya existe
        if ($resultado->num_rows) {
            //static es para que no se pierda el valor de alerta
            static::$alertas['error'][] = "El usuario ya existe";
        }
        return $resultado;
    }
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function comprobarPasswordVerificado($password)
    {
        $resultado =  password_verify($password, $this->password);
        //aqui ya tenemos la instancia de usuario
        if (!$this->confirmado || !$resultado) {
            self::$alertas['error'][] = "El usuario no ha sido confirmado o el password es incorrecto";
        } else {
            return true;
        }
    }

    public function creartoken()
    {
        $this->token = uniqid();
    }
}
