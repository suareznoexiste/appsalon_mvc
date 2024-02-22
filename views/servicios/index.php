<h1 class="nombre-pagina">Servicios </h1>
<p class="descripcion-pagina">Bienvenido al administrador servicios </p>

<?php
require_once __DIR__ . '/../templates/barra.php';

?>

<ul class="servicios">
    <?php foreach ($servicios as $servicio) { ?>
        <li>
            <p>Nombre: <span><?= $servicio->nombre ?></span></p>
            <p>precio: <span><?= $servicio->precio ?></span></p>
            <div class="acciones">


                <a class="boton" href="/servicios/actualizar?id=<?= s($servicio->id) ?>">actualizar</a>
            </div>
            <form action="/servicios/eliminar" method="post">
                <input type="hidden" name="id" value="<?= s($servicio->id) ?>">
                <input class="boton-eliminar" type="submit" value="Eliminar">

            </form>

        </li>

    <?php } ?>
</ul>