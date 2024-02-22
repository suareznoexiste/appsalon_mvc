<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">coloca tu nuevo password</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>
<?php if ($flag) return; ?>

<form method="POST" class="formulario 
">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Password">
    </div>
    <!-- <div class="campo">
        <label for="confirmar">Confirmar Password</label>
        <input type="password" name="confirmar" id="confirmar" placeholder="Repite tu Password">
    </div> -->
    <div class="campo">
        <input type="submit" value="Renovar Password" class="boton boton-verde">
    </div>
</form>

<div class="acciones">
    <a href="/crear-cuenta">Registrate</a>
    <a href="/">Ya tienes una Cuenta</a>
</div>