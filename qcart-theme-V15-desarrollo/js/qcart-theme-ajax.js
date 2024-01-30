jQuery(document).ready(function($) {
    $('#qcart-theme-recategorize-button').on('click', function() {
        var confirmRecategorize = confirm('¿Estás seguro de que deseas recategorizar los posts? Esta acción puede tardar un tiempo dependiendo del número de posts en tu sitio.'); 
        if (confirmRecategorize) {
        $('.loading-overlay').show().css({
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(0, 0, 0, 0.5)', // Cambia esto para ajustar la opacidad del fondo
            zIndex: 9999 // Asegúrate de que la capa esté por encima de otros elementos
        });
        $.ajax({
            url: qcart_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'qcart_theme_recategorize_posts',
                nonce: qcart_ajax_object.nonce,
            },
            success: function(response) {
                $('.loading-overlay').hide();
                alert("Se Re-categorizaron correctamente los posts");
                //location.reload(); // Recargar la página una vez que se complete la recategorización
            },
            error: function(error) {
                $('.qcart-theme-loader').remove();
                alert('No se re-categorizó ningún post.');
                console.error(error);
                location.reload();
            }
        });
        }
    });
});