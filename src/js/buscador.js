//aqui se ejecuta el codigo cuando el documento esta listo . esto es una funcion anonima que se ejecuta cuando el documento esta listo
document.addEventListener('DOMContentLoaded', function () {

    iniciarApp();


});

 function iniciarApp() {
    //aqui se ejecutan las funciones que se necesiten para iniciar la app
 buscarporfecha();

 }

  function buscarporfecha() {   
      const fechaInput = document.querySelector('#fecha');	

      fechaInput.addEventListener('input', function(e) { 


       const fechaselecionada= e.target.value;
  
    window.location=`?fecha=${fechaselecionada}`

      });

  }