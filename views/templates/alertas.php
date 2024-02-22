<?php

//aqui lo que hacemos es que si hay alertas las recorremos y las mostramos
foreach ($alertas as $key => $mensajes) :
    foreach ($mensajes as $mensaje) : ?>
        <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endforeach ?>
<?php endforeach;
