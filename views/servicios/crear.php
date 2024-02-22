<h1 class="nombre-pagina">Servicios </h1>
<p class="descripcion-pagina">Ingresa los nuevos Servicios </p>

<?php
require_once __DIR__ . '/../templates/barra.php';
require_once __DIR__ . '/../templates/alertas.php';
isAdmin();
?>
<form action="/servicios/crear" method="post">


    <?php include __DIR__ . '/formulario.php'; ?>s


    <input class="boton" type="submit" value="Guardar Registro">
</form>