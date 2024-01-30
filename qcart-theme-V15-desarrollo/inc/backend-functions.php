<?php
/**
 * qcart_theme_add_submenu
 * 
 * agrega el menu y submenus en el 
 * administrador de wordpress para el funcionamiento
 * del tema Qcart Theme
 * 
 * @return void
 */
function qcart_theme_add_submenu() {
    add_menu_page(
        'Qopciones', // Título del menú principal
        'Qopciones', // Título del menú en la página de plugins
        'edit_posts', // Capacidad requerida para acceder a esta página
        'qcart-theme-options', // Slug del menú principal
        '', // No es necesario un callback para el menú principal, déjalo en blanco
        '', // Icono del menú (puedes agregar una URL del icono si lo deseas)
        999 // Posición del menú (ajústala a tu preferencia)
    );

    add_submenu_page(
        'qcart-theme-options', // Slug del menú principal
        'QColores', // Título del submenú
        'QColores', // Título de la página
        'edit_posts', // Capacidad requerida para acceder a esta página
        'qcart-theme-colors', // Slug de la página del submenú
        'qcart_theme_colors_page' // Callback de la página del submenú
    );

    add_submenu_page(
        'qcart-theme-options', // Slug del menú principal
        'Qlinks', // Título del submenú
        'Qlinks', // Título de la página
        'edit_posts', // Capacidad requerida para acceder a esta página
        'qcart-theme-links', // Slug de la página del submenú
        'qcart_theme_links_page' // Callback de la página del submenú
    );

    add_submenu_page(
        'qcart-theme-options', // Slug del menú principal
        'QCategorías', // Título del submenú
        'QCategorías', // Título de la página
        'edit_posts', // Capacidad requerida para acceder a esta página
        'qcart-theme-categories', // Slug de la página del submenú
        'qcart_theme_categories_page' // Callback de la página del submenú (la función que te proporcionaré más adelante)
    );

    add_submenu_page(
        'qcart-theme-options',
        'QBanner',
        'QBanner',
        'edit_posts',
        'testimonial_slider',
        'testimonial_slider_page_callback'
    );

    add_submenu_page(
        'qcart-theme-options', // Título de la página
        'Qredes', // Título del menú
        'Qredes',
        'edit_posts',
        'qcart-theme-rrss', // Slug de la página
        'qcart_theme_rrss_page_callback', // Función de callback para mostrar la página
    );

    add_submenu_page('qcart-theme-options', 
    'Imágenes de Categorías',  
    'Imágenes de Categorías', 
    'edit_posts', 
    'category-images', 
    'qcart_theme_category_images_page');

    add_submenu_page('qcart-theme-options', 
    'Página de inicio',  
    'Página de inicio', 
    'edit_posts', 
    'home_page_config', 
    'home_page_config_page');

    add_submenu_page(
        'qcart-theme-options',
        'Recetarios',
        'Recetarios',
        'edit_posts',
        'gestion_recetarios',
        'mostrar_pagina_recetarios'
    );

    
    // Eliminar el primer elemento del arreglo global de menús
    global $submenu;
    unset($submenu['qcart-theme-options'][0]);
}
add_action('admin_menu', 'qcart_theme_add_submenu');


function qcart_theme_rrss_page_callback(){
    if (isset($_POST['redes_sociales'])) {
        // Si se envió el formulario, guarda la configuración
        $redes_sociales = $_POST['redes_sociales'];
        
        // Completa automáticamente las URLs con "https://" si no incluyen "http://" o "https://"
        foreach ($redes_sociales as $nombre => $enlace) {
            if (!empty($enlace) && !preg_match('/^(http|https):\/\//i', $enlace)) {
                $redes_sociales[$nombre] = 'https://' . $enlace;
            }
        }

        update_option('redes_sociales', $redes_sociales);
        echo '<div class="updated"><p>Configuración de redes sociales guardada.</p></div>';
    }

    ?>
    <div class="wrap">
        <h2>Configuración de Redes Sociales</h2>

        <form method="post" action="">
            <?php
            // Recupera los valores de redes sociales almacenados en la base de datos
            $redes_sociales = get_option('redes_sociales');
            
            // Define los nombres de las redes sociales que deseas configurar
            $redes_sociales_nombres = array(
                'Facebook',
                'Twitter',
                'Instagram',
                'LinkedIn',
                'Pinterest',
                'Threads',
                'TikTok',
                'Youtube'
                // Agrega más redes sociales según tus necesidades
            );
            
            // Muestra campos de entrada para cada red social
            foreach ($redes_sociales_nombres as $nombre) {
                $enlace = isset($redes_sociales[$nombre]) ? esc_url($redes_sociales[$nombre]) : '';
                ?>
                <p>
                    <label for="<?php echo esc_attr($nombre); ?>"><?php echo esc_html($nombre); ?>:</label>
                    <input type="text" id="<?php echo esc_attr($nombre); ?>" name="redes_sociales[<?php echo esc_attr($nombre); ?>]" value="<?php echo esc_attr($enlace); ?>" />
                </p>
                <?php
            }
            ?>

            <p>
                <input type="submit" class="button-primary" value="Guardar Configuración" />
            </p>
        </form>
    </div>
    <?php
}



/**
 * custom_sanitize_permalink
 *
 * con esto sanitizamos los permalink
 * de los posts
 * 
 * @param  mixed $data
 * @param  mixed $postarr
 * @return void
 */
function custom_sanitize_permalink( $data, $postarr ) {
    // Verifica si se está agregando o actualizando un post
    if ( isset( $postarr['ID'] ) && $postarr['post_type'] === 'post' ) {
        // Obtén el título del post
        $post_title = $data['post_title'];
        
        // Remueve emoticones y caracteres especiales del título
        $cleaned_title = preg_replace( '/[^\p{L}\p{N}\s-]+/u', '', $post_title );

        // Genera el nuevo permalink basado en el título limpio
        $new_permalink = sanitize_title_with_dashes( $cleaned_title );

        // Actualiza el slug del post con el nuevo permalink
        $data['post_name'] = $new_permalink;
    }

    return $data;
}

add_filter( 'wp_insert_post_data', 'custom_sanitize_permalink', 10, 2 );



function qcart_theme_category_images_page() {
    wp_enqueue_media();
    $categories = get_categories(array('exclude' => '1'));
    $options = get_option('qcart_theme_category_images');
    ?>
    <div class="wrap">
        <h2>Imágenes de Categorías</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields('qcart-theme-category-options');
                do_settings_sections('qcart-theme-category-options');
                
                // Mostrar las categorías y campos de imagen
                foreach ($categories as $category) {
                    $category_id = $category->cat_ID;
                    $image_url = isset($options[$category_id]) ? $options[$category_id] : '';
            ?>
                    <div>
                    <h3><?php echo esc_html($category->name); ?></h3>
                    <div class="image-preview">
                        <img class="image-preview-img" src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                    <input type="hidden" class="image-upload-input" id="qcart_theme_category_images[<?php echo $category_id; ?>]" name="qcart_theme_category_images[<?php echo $category_id; ?>]" value="<?php echo esc_url($image_url); ?>" />
                    <button class="upload-image-button button" data-category-id="<?php echo $category_id; ?>">Seleccionar Imagen</button>
                    <button class="delete-image-button button" data-category-id="<?php echo $category_id; ?>">Eliminar Imagen</button>
                </div>
            <?php
                }
                submit_button();
            ?>
        </form>
    </div>
    <style>
        .image-preview {
            margin-top: 10px;
        }

        .image-preview .image-preview-img {
            max-width: 200px;
        }
    </style>
    <script>
jQuery(document).ready(function($) {
    $('.upload-image-button').click(function(e) {
        e.preventDefault();
        var $button = $(this);
        var customUploader = wp.media({
            title: 'Seleccionar Imagen',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: false
        });

        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            var imageUrl = attachment.url;
            var categoryID = $button.data('category-id');

            // Obtén el campo de entrada de imagen y previsualización específico para la categoría actual
            var $imageInput = $('#qcart_theme_category_images\\[' + categoryID + '\\]');
            console.log($imageInput);
            var $imagePreview = $button.parent().find('.image-preview-img');
            console.log($imagePreview);

            // Establece la URL de la imagen solo en la categoría correspondiente
            $imageInput.val(imageUrl);
            $imagePreview.attr('src', imageUrl);
        });

        customUploader.open();
    });


    $('.delete-image-button').click(function(e) {
        e.preventDefault();
        var $button = $(this);
        var categoryID = $button.data('category-id');

        // Obtén el campo de entrada de imagen y previsualización específico para la categoría actual
        var $imageInput = $('#qcart_theme_category_images\\[' + categoryID + '\\]');
        var $imagePreview = $button.parent().find('.image-preview-img');

        // Elimina la URL de la imagen y la imagen previsualizada
        $imageInput.val('');
        $imagePreview.attr('src', '');
    });


});
    </script>
    <?php
}


function qcart_theme_initialize_category_options() {
    register_setting('qcart-theme-category-options', 'qcart_theme_category_images', 'qcart_theme_sanitize_image');

    foreach (get_categories(array('exclude' => '1')) as $category) {
        $category_id = $category->cat_ID;
        add_settings_field(
            'qcart-theme-category-image-' . $category_id,
            'Seleccionar imagen para la categoría: ' . $category->name,
            function () use ($category_id) {
                $option_name = 'qcart_theme_category_images[' . $category_id . ']';
                $options = get_option($option_name);
                $image_url = isset($options) ? $options : '';
                echo '<input type="text" id="' . $option_name . '" name="' . $option_name . '" value="' . esc_attr($image_url) . '" class="regular-text" />';
                echo '<input type="button" class="button-secondary upload-image-button" data-category-id="' . $category_id . '" value="Cargar Imagen" />';
            },
            'qcart-theme-category-options',
            'default'
        );
    }
}
add_action('admin_init', 'qcart_theme_initialize_category_options');

// Función para renderizar el campo de imagen para cada categoría
function qcart_theme_render_category_image_field($args) {
    $option_name = 'qcart_theme_category_images';
    $category_id = $args['category_id'];
    $options = get_option($option_name);

    $image_url = isset($options[$category_id]) ? $options[$category_id] : '';

    echo '<input type="text" id="' . $option_name . '[' . $category_id . ']" name="' . $option_name . '[' . $category_id . ']" value="' . $image_url . '" class="regular-text" />';

    echo '<input type="button" class="button-secondary" id="' . $category_id . '_upload_image_button" value="Cargar Imagen" />';
}

function home_page_config_page() {
    // Comprueba si se ha enviado un formulario y verifica la seguridad.
    if (isset($_POST['home_page_subtitulo'])) {
        check_admin_referer('guardar_configuracion_home_page', 'security');

        // Guarda el valor del campo "Subtítulo" en la opción 'home_page_subtitulo'.
        update_option('home_page_subtitulo', sanitize_text_field($_POST['home_page_subtitulo']));

        // Muestra un mensaje de éxito.
        echo '<div class="updated"><p>Configuración guardada.</p></div>';
    }

    // Obtiene el valor actual de "Subtítulo" de las opciones.
    $subtitulo = get_option('home_page_subtitulo');
    
    ?>
    <div class="wrap">
        <h2>Configuración de la Página de Inicio</h2>
        <form method="post">
            <?php wp_nonce_field('guardar_configuracion_home_page', 'security'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Subtítulo</th>
                    <td>
                        <textarea name="home_page_subtitulo" rows="4" cols="50"><?php echo esc_textarea($subtitulo); ?></textarea>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar" />
            </p>
        </form>
    </div>
    <?php
}

//recetarios

function mostrar_pagina_recetarios() {
    // Agrega el cargador de medios
    wp_enqueue_media();
    
    // Obtener la opción actual de recetarios
    $recetarios_option = get_option('recetarios_option', array());

    // Procesar la subida del PDF
    if (isset($_POST['pdf_attachment_id']) && !empty($_POST['pdf_attachment_id'])) {
        $pdf_attachment_id = sanitize_text_field($_POST['pdf_attachment_id']);
        
        // Guardar la información del PDF en la opción de recetarios
        $recetarios_option[] = $pdf_attachment_id;
        update_option('recetarios_option', $recetarios_option);
        
        echo '<p style="color: green;">PDF subido correctamente. ID de adjunto: ' . esc_html($pdf_attachment_id) . '</p>';
    }

    if (isset($_GET['delete_pdf'])) {
        $pdf_to_delete = sanitize_text_field($_GET['delete_pdf']);
        
        // Obtener las URL de los archivos adjuntos para comparar
        $pdf_urls_to_delete = array_map('wp_get_attachment_url', $recetarios_option);
        
        // Buscar el índice del PDF a eliminar
        $index_to_delete = array_search(wp_get_attachment_url($pdf_to_delete), $pdf_urls_to_delete);
        
        // Eliminar el PDF de la opción de recetarios
        if ($index_to_delete !== false) {
            unset($recetarios_option[$index_to_delete]);
            update_option('recetarios_option', $recetarios_option);
            echo '<p style="color: green;">PDF eliminado correctamente.</p>';

            ?>
            <script>
                var currentUrlParts = window.location.href.split('?');
                var newUrl = currentUrlParts[0] + '?page=gestion_recetarios';
                history.replaceState({}, document.title, newUrl);
            </script>
            <?php
            
        } else {
            echo '<p style="color: red;">Error al eliminar el PDF.</p>';
        }
    }



    ?>
    <div class="wrap">
        <h1>Gestión de Recetarios</h1>

        <!-- Formulario para subir PDFs utilizando el cargador de medios -->
        <form method="post" enctype="multipart/form-data" action="">
            <label for="pdf_upload">Subir PDF:</label>
            <input type="button" class="button" id="upload_pdf_button" value="Seleccionar PDF">
            <input type="hidden" name="pdf_attachment_id" id="pdf_attachment_id" value="">
            <input type="submit" class="button" name="save_pdf" value="Guardar PDF">
            <p id="pdf_preview"></p>
        </form>

        <!-- Lista de PDFs existentes -->
        <h2>Recetarios existentes:</h2>
        <ul>
            <?php
            // Muestra los PDFs existentes
            foreach ($recetarios_option as $pdf_attachment_id) {
                $pdf_url = wp_get_attachment_url($pdf_attachment_id);
                echo '<li><a href="' . esc_url($pdf_url) . '" target="_blank">' . esc_html(get_the_title($pdf_attachment_id)) . '</a> - <a href="?page=gestion_recetarios&delete_pdf=' . esc_attr($pdf_attachment_id) . '">Eliminar</a></li>';
            }
            ?>
        </ul>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Configurar el cargador de medios
            var mediaUploader;

            $('#upload_pdf_button').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Configurar el cargador de medios
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Seleccionar PDF',
                    button: {
                        text: 'Seleccionar PDF'
                    },
                    library: {
                        type: 'application/pdf' // Limitar a archivos PDF
                    },
                    multiple: false
                });

                // Cuando se selecciona un archivo
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();

                    // Actualizar la vista previa y el campo oculto
                    $('#pdf_preview').html('PDF seleccionado: ' + attachment.filename);
                    $('#pdf_attachment_id').val(attachment.id);
                });

                // Abrir el cargador de medios
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

//recetarios