let paso;const paginainicial=1,paginafinal=3;paso=1;const cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarseccion(),tabs(),Paginacion(),paginaSiguiente(),paginaAnterior(),consultarapi(),seleccionarHora(),seleccionarFecha(),idCliente(),nombreCliente(),mostrarAlerta(),mostrarResumen()}function mostrarseccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");let t="#paso-"+paso,a=document.querySelector(t);a&&a.classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");let n=document.querySelector(`[data-paso="${paso}"]`);n&&n.classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarseccion(paso),
//!aqui lo mandamos a llamar por que queremos que se ejecute cada vez que se haga click en un boton
Paginacion()}))})}function Paginacion(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarseccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,Paginacion())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,Paginacion())}))}async function consultarapi(){try{const e=location.origin+"/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:a,precio:o}=e,n=document.createElement("P");n.textContent=a,n.classList.add("nombre-servicio");const c=document.createElement("P");c.textContent="$ "+o,c.classList.add("precio-servicio");const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{servicios:t}=cita,{id:a}=e,o=document.querySelector(`[data-id-servicio="${a}"]`);t.some(e=>e.id===a)?(o.classList.remove("seleccionado"),cita.servicios=t.filter(e=>e.id!==a)):(cita.servicios=[...t,e],o.classList.add("seleccionado"))}function idCliente(){cita.id=document.querySelector("#id").value}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Fines de semana no permitidos","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>18?(e.target.value="",mostrarAlerta("Hora No Válida","error",".formulario")):cita.hora=e.target.value}))}function mostrarAlerta(e,t,a){if(document.querySelector(".alerta"))return;const o=document.createElement("DIV");o&&(o.textContent=e,o.classList.add("alerta")),"error"===t&&o.classList.add("error");const n=document.querySelector(a);n&&n.appendChild(o),setTimeout(()=>{o.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return console.log(cita),void mostrarAlerta("Faltan datos de Servicios, Fecha u Hora","error",".contenido-resumen",!1);const{nombre:t,fecha:a,hora:o,servicios:n}=cita,c=document.createElement("H3");c.textContent="Resumen de Servicios",e.appendChild(c),n.forEach(t=>{const{id:a,precio:o,nombre:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=n;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+o,c.appendChild(r),c.appendChild(i),e.appendChild(c)});const r=document.createElement("H3");r.textContent="Resumen de Cita",e.appendChild(r);const i=document.createElement("P");i.innerHTML="<span>Nombre:</span> "+t;const s=new Date(a),d=s.getMonth(),l=s.getDate()+2,u=s.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML="<span>Fecha:</span> "+m;const v=document.createElement("P");v.innerHTML=`<span>Hora:</span> ${o} Horas`;const h=document.createElement("BUTTON");h.classList.add("boton"),h.textContent="Reservar Cita",h.onclick=reservarCita,e.appendChild(i),e.appendChild(p),e.appendChild(v),e.appendChild(h)}async function reservarCita(){const{id:e,fecha:t,hora:a,servicios:o}=cita,n=o.map(e=>e.id),c=new FormData;c.append("fecha",t),c.append("hora",a),c.append("serviciosId",n),c.append("usuariold",e);const r=location.origin+"/api/citas",i=(await fetch(r,{method:"POST",body:c})).json();try{i&&Swal.fire({icon:"success",title:"cita creada",text:`tu cita ha sido creada correctamente para ${t} a las ${a}`,button:"OK"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"hubo un error al ingresar la cita !"})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));