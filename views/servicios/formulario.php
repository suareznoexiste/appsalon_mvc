<div class="campo">

    <label for="nombre">Nombre Servicio</label>
    <input type="text" name="nombre" id="nombre" placeholder="ingresa tu nombre" 
    value="<?php echo s($servicios->nombre); ?>"
    >

</div>
<div class="campo">
    <label for="precio">Precio Servicio</label>
    <input type="number" name="precio" id="precio" 
    value="<?php echo s($servicios->precio); ?>"
    required>
</div>