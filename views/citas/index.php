<h1 class="nombre-pagina">Nueva Cita </h1>
<p class="descripcion-pagina">Ingresa tus datos y servicios </p>

<div id="app">
    <div class="barra">
        <p> Hola: <?= $nombre ?></p>

        <a href="/logout" class="boton">Cerrar Session</a>

    </div>

    <nav class="tabs">
        <button type="button" data-paso="1">Servicio</button>
        <button type="button" data-paso="2">Datos</button>
        <button type="button" data-paso="3">Resumen</button>

    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p>elige tu servicios</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2> Datos</h2>
        <p>ingress tus datos</p>

        <form action="" class="formulario">

            <div class="campo">
                <label id="">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value="<?= $nombre ?>">


            </div>
            <div class="campo">
                <label id="">Fecha</label>
                <input type="date" id="fecha" placeholder="Tu Fecha">
            </div>
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <div class="campo">
                <label id="">Hora</label>
                <input type="time" id="hora" placeholder="Tu Hora">
            </div>






        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

</div>
<div class="paginacion">
    <button type="button" id="anterior">Anterior</button>
    <button type="button" id="siguiente">Siguiente</button>
</div>
</div>

<?php
echo $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
";
?>