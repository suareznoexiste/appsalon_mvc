

let paso;
const paginainicial = 1
const paginafinal = 3

paso = paginainicial;
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


//aqui se ejecuta el codigo cuando el documento esta listo . esto es una funcion anonima que se ejecuta cuando el documento esta listo
document.addEventListener('DOMContentLoaded', function () {

    iniciarApp();


});


function iniciarApp() {
    //mostramos la seccion 1
    mostrarseccion();
    //inicializamos los tabs

    tabs();
    Paginacion();
    paginaSiguiente();
    paginaAnterior();
    consultarapi();
    seleccionarHora();
    seleccionarFecha();
    idCliente();
    nombreCliente();
    mostrarAlerta();
    mostrarResumen();

}



function mostrarseccion() {
    //lequitamos la clase mostrar a la seccion anterior por que ya no la queremos mostrar
    const seccionaterior = document.querySelector('.mostrar');
    //como el dom no genera un error si no encuentra el elemento que estamos buscando, podemos hacer una validacion para saber si el elemento existe
    if (seccionaterior) {

        seccionaterior.classList.remove('mostrar');
    }

    //aqui seleccionamos la seccion que queremos mostrar
    let pasoSelector = '#paso-' + paso;
    let seccion = document.querySelector(pasoSelector);
    if (seccion) {
        //aqui le asignamos la clase mostrar a la seccion que queremos mostrar
        seccion.classList.add('mostrar');
    }




    //******************************************************************************************************************** */

    const tabsanteriores = document.querySelector(`.actual`);
    if (tabsanteriores) {


        tabsanteriores.classList.remove('actual');
    }

    //aqui seleccionamos el boton que queremos activar
    //como recibimos el paso entonces se hace dinamica la forma del selector para seleccionar el boton
    let botonselector = document.querySelector(`[data-paso="${paso}"]`);
    if (botonselector) {
        //aqui le asignamos la clase activo al boton que queremos activar
        botonselector.classList.add('actual');
    }


}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            // e = evento
            // e.target = elemento que disparo el evento
            // e.target.dataset.paso = valor del atributo data-paso del elemento que disparo el evento
            paso = parseInt(e.target.dataset.paso);

            mostrarseccion(paso);
            //!aqui lo mandamos a llamar por que queremos que se ejecute cada vez que se haga click en un boton
            Paginacion();



        });
    });
}

function Paginacion() {
    //? basicamente Validamos cuando si y cuando no 
    const botonSiguiente = document.querySelector('#siguiente');
    const botonAnterior = document.querySelector('#anterior');

    //dependiendo del paso en el que estemos, mostramos o ocultamos los botones
    if (paso === 1) {
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }
    else if (paso === 3) {

        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.add('ocultar');
        mostrarResumen();
    }
    else {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }
    mostrarseccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {

        if (paso <= paginainicial) return;
        paso--;

        Paginacion();
    })
}
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {

        if (paso >= paginafinal) return;
        paso++;

        Paginacion();
    })
}
async function consultarapi() {

    try {
        const Url = `${location.origin}/api/servicios`
        const resultado = await fetch(Url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }


}
function mostrarServicios(servicios) {

    servicios.forEach(servicios => {
        const { id, nombre, precio } = servicios;
        //DOM Scripting
        //Generar el nombre
        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;
        nombreServicio.classList.add('nombre-servicio');
        //Generar el precio
        const precioServicio = document.createElement('P');
        precioServicio.textContent = `$ ${precio}`;
        precioServicio.classList.add('precio-servicio');
        //Generar el div
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        //si lo mandamos a llamar y le pasamos un argumento se pasara el argumento completo y lo que que queremos es que solo se paso solo  uno cada que damos click
        servicioDiv.onclick = function () {
            seleccionarServicio(servicios);
        }
        //Seleccionar el div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        //Inyectar en el HTML
        document.querySelector('#servicios').appendChild(servicioDiv);
    })
}
function seleccionarServicio(servicio) {
    const { servicios } = cita;
    const { id } = servicio;
    //identificando elemento al que se le da click
    const elemento = document.querySelector(`[data-id-servicio="${id}"]`);

    //some es un metodo que nos permite saber si un elemento existe en un arreglo
    if (servicios.some(agregado => agregado.id === id)) {

        elemento.classList.remove('seleccionado');

        //filter sirve para sacar un elemento
        cita.servicios = servicios.filter(agregado => agregado.id !== id)

    }
    else {
        cita.servicios = [...servicios, servicio];
        elemento.classList.add('seleccionado');

    }
}
function idCliente() {
    cita.id = document.querySelector('#id').value;




}
function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}


function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }

    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if (hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora No Válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;

        }
    })
}
function mostrarAlerta(mensaje, tipo, seccion) {
    //si ya existe una alerta no se crea otra
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        return;
    }
    const alerta = document.createElement('DIV');
    if (alerta) {
        alerta.textContent = mensaje;
        alerta.classList.add('alerta');
    }

    if (tipo === 'error') {
        alerta.classList.add('error');
    }
    //insertar en el html
    const formulario = document.querySelector(seccion);
    if (formulario) {
        formulario.appendChild(alerta);
    }

    //eliminar la alerta despues de 3 segundos
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}
function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el Contenido de Resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        console.log(cita);
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen', false);

        return;
    }

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;



    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    // Heading para Cita en Resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Boton para Crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const { id, fecha, hora, servicios } = cita
    const idServicio = servicios.map(servicios => servicios.id)

    const datos = new FormData();

    datos.append('fecha', fecha)
    datos.append('hora', hora)
    datos.append('serviciosId', idServicio)
    datos.append('usuariold', id)




    const Url = `${location.origin}/api/citas`;
    const repuesta = await fetch(Url, {

        method: 'POST',
        body: datos

    });
    const resultado = repuesta.json();

    try {
        if (resultado) {

            Swal.fire({
                icon: "success",
                title: "cita creada",
                text: `tu cita ha sido creada correctamente para ${fecha} a las ${hora}`,
                button: "OK"

            }).then(() => {
                window.location.reload();
            }

            )

        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "hubo un error al ingresar la cita !",

        });
    }

}




