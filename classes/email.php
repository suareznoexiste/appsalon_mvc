<?php


namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{


    public $email;
    public $nombre;

    public $token;




    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;

        $this->token = $token;
    }
    public function enviarConfirmacion()
    {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];


        $phpmailer->setFrom('cuentasetfrom@gmail.com');
        $phpmailer->addAddress($this->email, $this->nombre);
        $phpmailer->Subject = 'Confirma tu cuenta';

        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Para confirmar tu cuenta haz click en el siguiente enlace</p>';
        $contenido .= '<a href="'. $_ENV['APP_URL'] . '/confirmar-cuenta?token=' . $this->token . '">Confirmar cuenta</a>';
        $contenido .= 'si no fuiste tu quien solicito la cuenta, ignora este mensaje';
        $contenido .= '</html>';



        $phpmailer->Body = $contenido;

        $phpmailer->send();
    }
    public function enviarIntrucciones()
    {

        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];

        $phpmailer->setFrom('cuentasetfrom@gmail.com');
        $phpmailer->addAddress($this->email, $this->nombre);
        $phpmailer->Subject = 'restablecer contraseña';

        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Para renovar tu contraseña haz click en el siguiente enlace</p>';
        $contenido .= '<a href="'. $_ENV['APP_URL'] . '/recuperar?token=' . $this->token . '">Renovar contraseña</a>';

        $phpmailer->Body = $contenido;

        $phpmailer->send();
    }
}
