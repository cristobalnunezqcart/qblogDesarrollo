jQuery(document).ready(function($) {
    $('#abrirCarrito').on('click', function(e) {
      e.preventDefault();
  
      // Realizar solicitud AJAX
      $.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
          'action': 'abrir_carrito' // Nombre de la acción de WordPress
        },
        success: function(response) {
          console.log('Abrir carrito:', response);
        },
        error: function(xhr, status, error) {
          console.error('Error al abrir el carrito:', error);
        }
      });
    });
  });