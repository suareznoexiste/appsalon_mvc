<h1 class="nombre-pagina">Servicios </h1>
<p class="descripcion-pagina">Actualizar Servicios </p>

<?php
require_once __DIR__ . '/../templates/barra.php';

isAdmin();
?>

<form  method="post">


<?php include __DIR__ . '/formulario.php'; ?>s


<input class="boton" type="submit" value="actualizar Registro"> 
</form>