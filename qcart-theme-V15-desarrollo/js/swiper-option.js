$( document ).ready(function() {
  var swiper = new Swiper(".banner", {
    loop: true,
    effect: "fade",
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      dynamicBullets: true,
      clickable: true,
    },
    centeredSlides: true,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
    },
  });




var swiper_dos = new Swiper('.swiper2', {
    spaceBetween: 0,
    navigation: {
      nextEl: '.swiper-button-next2', // Selector del botón de avance
      prevEl: '.swiper-button-prev2' // Selector del botón de retroceso
    },
    loop: true, // Hace que el carrusel sea infinito
    autoplay: {
      delay: 6000, // Intervalo de cambio de diapositivas en milisegundos (6 segundos)
      disableOnInteraction: true // Permite que el autoplay continúe después de la interacción del usuario
    }
});


// Función para actualizar el valor de slidesPerView
function updateSlidesPerView() {

  var numCategories = $('.swiperslide2').length;

  // Verifica el tamaño de la pantalla
  if (window.innerWidth < 768) {
      swiper_dos.params.slidesPerView = Math.min(3, numCategories); // Muestra 2 elementos en dispositivos móviles
      //swiper_dos.params.spaceBetween = 1;
      var elemento = document.querySelector(".swiper-outer-container");
      elemento.style.display = 'block';
      if(document.querySelector(".banner-separador") ){
        document.querySelector(".banner-separador").style.display = 'block';
      }
  } else {
      swiper_dos.params.slidesPerView = Math.min(6, numCategories); 
      swiper_dos.params.spaceBetween = 0;
      var elemento = document.querySelector(".swiper-outer-container");
      //elemento.style.cssText = "display:none;";
      elemento.style.display = 'block';
  }

  // Actualiza el carrusel
  swiper_dos.update();
}

// Llama a la función al cargar la página
updateSlidesPerView();

// Detecta cambios en el tamaño de la ventana y actualiza el valor
window.addEventListener('resize', updateSlidesPerView);





} );

//Abrir Modal del banner de categorías
document.addEventListener('DOMContentLoaded', function () {
  var abrirModalBtn = document.getElementById('abrirModalBtn');
  var cerrarModalBtn = document.getElementById('cerrarModalBtn');
  var miModal = document.getElementById('miModal');

  abrirModalBtn.addEventListener('click', function () {
    miModal.style.display = 'block';
  });

  cerrarModalBtn.addEventListener('click', function () {
    miModal.style.display = 'none';
  });

  window.addEventListener('click', function (event) {
    if (event.target === miModal) {
      miModal.style.display = 'none';
    }
  });
});




