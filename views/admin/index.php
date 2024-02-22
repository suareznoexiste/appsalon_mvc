<h1 class="nombre-pagina">admin Cita </h1>
<p class="descripcion-pagina">Bienvenido al administrador de datos y servicios </p>

<?php
require_once __DIR__ . '/../templates/barra.php';

isAdmin();
?>
<h2> buscar fechas</h2>
<div class="busqueda">
   <form action="" class="formulario">
      <div class="campo">
         <label for="fecha">Ingresa la fecha</label>
         <input type="date" name="fecha" id="fecha" value="<?= $fecha ?>">
      </div>
   </form>
</div>

<?php

if (count($citas) === 0) {
   echo "<h2>No hay resultados</h2>";
}
?>
<div id="citas-admin">
   <ul class="citas">
      <?php $idCita = null; ?>


      <?php foreach ($citas as $Key => $cita) : ?>

         <?php if ($idCita != $cita->id) {
            $total = 0;
         ?>

            <li>
               <p> ID: <span> <?php echo $cita->id; ?></span> </p>
               <p> Hora: <span> <?php echo $cita->hora; ?></span> </p>
               <p> Cliente: <span> <?php echo $cita->cliente; ?></span> </p>
               <p> Email: <span> <?php echo $cita->email; ?></span> </p>
               <p> Telefono: <span> <?php echo $cita->telefono; ?></span> </p>

               <?php $idCita = $cita->id; ?>

               <h3>Servicios</h3>

            <?php } ?>
            <?php $total += $cita->precio; ?>
            <p class="servicio"> <?php echo $cita->servicio . "  " . $cita->precio ?></p>
            </li>
            <?php
            //! aqui lo que hago es que si el id de la cita es igual al id de la cita anterior, no imprima el id de la cita, pero si es diferente, imprima el id de la cita
            $actual = $cita->id;

            $proximo = $citas[$Key + 1]->id;

            if (isUltimo($actual, $proximo)) {
               echo "<p> Total: $total</p>";
            ?>
               <form action="/api/eliminar" method="post">

                   <input type="hidden" name="id" value="<?=$cita->id?>">
                  <input type="submit" value="Eliminar" class="boton-eliminar" 
                   >
               </form>

            <?php   }
            ?>
         <?php endforeach; ?>



   </ul>
</div>

<?php
$script = "<script src='build/js/buscador.js'></script>"

?>