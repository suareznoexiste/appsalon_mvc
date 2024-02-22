<h1 class="nombre-pagina">Renovar</h1>
<p class="descripcion-pagina">olvide mi contraseña</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<div class="formulario">
    <form method="POST" class="formulario">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu Email">
        </div>
        <div class="campo">
            <input type="submit" value="enviar instrucciones" class="boton boton-verde">
        </div>
    </form>
    <div class="acciones">
        <a href="/crear-cuenta">Registrate</a>
        <a href="/">Ya tienes una Cuenta</a>
    </div>