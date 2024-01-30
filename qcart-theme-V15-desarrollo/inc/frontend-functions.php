<?php


/**
 * custom_elementor_shape_shortcode
 * crear shortcode para agregar elemento superior
 * de diseño
 * 
 * @return void
 */
function custom_elementor_shape_shortcode() {
    ob_start();
    ?>
    <div class="elementor-shape elementor-shape-top" data-negative="false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
            <path class="elementor-shape-fill" d="M1000,4.3V0H0v4.3C0.9,23.1,126.7,99.2,500,100S1000,22.7,1000,4.3z"></path>
        </svg>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}
add_shortcode('custom_elementor_shape', 'custom_elementor_shape_shortcode');


/**
 * qcart_theme_custom_css
 *
 * disponibilizar colores globales guardados en la base de datos
 * para usarlos en archivos .css
 * 
 * @return void
 */
function qcart_theme_custom_css() {
    $color_primary = get_option('qcart_theme_color_primary', '#000000');
    $color_secondary = get_option('qcart_theme_color_secondary', '#ffffff');

    $custom_css = "
        :root {
            --color-primary: {$color_primary};
            --color-secondary: {$color_secondary};
        }
    ";

    echo '<style type="text/css">' . $custom_css . '</style>';
}
add_action('wp_head', 'qcart_theme_custom_css');


/**
 * qcart_theme_links_page
 *
 * renderizar página de links 
 * personalizados del tema
 * @return void
 */
function qcart_theme_links_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('No tienes permisos suficientes para acceder a esta página.'));
    }

    // Guardar las opciones cuando se envía el formulario
    if (isset($_POST['nuestros_productos_submit'])) {
        update_option('nuestros_productos', sanitize_text_field($_POST['nuestros_productos']));
    }

    // Obtener los valores de las opciones guardadas en la base de datos
    $color_primary = get_option('nuestros_productos', '');

    ?>
    <div class="wrap">
        <h1>Configuración de links externos</h1>
        <form method="post" action="">
            <?php wp_nonce_field('nuestros_productos_nonce', 'nuestros_productos_nonce'); ?>
            <label for="nuestros_productos">Link externo:</label>
            <input type="text" name="nuestros_productos" id="nuestros_productos" value="<?php echo esc_attr($color_primary); ?>"><br>
            <input type="submit" name="nuestros_productos_submit" value="Guardar cambios" class="button-primary">
        </form>
    </div>
    <?php
}


/**
 * qcart_theme_colors_page
 *
 * renderizar página de colores 
 * personalizados del tema
 * @return void
 */
function qcart_theme_colors_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('No tienes permisos suficientes para acceder a esta página.'));
    }

    // Guardar las opciones cuando se envía el formulario
    if (isset($_POST['qcart_theme_colors_submit'])) {
        update_option('qcart_theme_color_primary', sanitize_text_field($_POST['qcart_theme_color_primary']));
        update_option('qcart_theme_color_secondary', sanitize_text_field($_POST['qcart_theme_color_secondary']));
    }

    // Obtener los valores de las opciones guardadas en la base de datos
    $color_primary = get_option('qcart_theme_color_primary', '#000000');
    $color_secondary = get_option('qcart_theme_color_secondary', '#ffffff');

    ?>
    <div class="wrap">
        <h1>Configuración de Colores</h1>
        <form method="post" action="">
            <?php wp_nonce_field('qcart_theme_color_nonce', 'qcart_theme_color_nonce'); ?>
            <label for="qcart_theme_color_primary">Color principal:</label>
            <input type="text" name="qcart_theme_color_primary" id="qcart_theme_color_primary" value="<?php echo esc_attr($color_primary); ?>"><br>

            <label for="qcart_theme_color_secondary">Color secundario:</label>
            <input type="text" name="qcart_theme_color_secondary" id="qcart_theme_color_secondary" value="<?php echo esc_attr($color_secondary); ?>"><br>

            <input type="submit" name="qcart_theme_colors_submit" value="Guardar cambios" class="button-primary">
        </form>
    </div>
    <?php
}


/**
 * qcart_theme_categories_page
 *
 * renderizar página personalizada de categorías
 * @return void
 */
function qcart_theme_categories_page() {
    ?>
    <div class="wrap">
        <h1>QCategorías</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('qcart_theme_categories_options');
            do_settings_sections('qcart_theme_categories_options');
            submit_button('Guardar cambios');
            ?>
            <button type="button" class="button qcart-theme-recategorize-button"  id="qcart-theme-recategorize-button">Recategorizar Posts</button>
        </form>
    </div>
    <?php
}


//redes sociales flotantes

function botones_redes_sociales_shortcode() {
    // Recupera los enlaces de las redes sociales almacenados en la base de datos
    $redes_sociales = get_option('redes_sociales');

    // Define un arreglo de iconos correspondientes a cada red social
    $iconos_redes_sociales = array(
        'Facebook' => 'fab fa-facebook-f',
        'Twitter' => 'bi bi-twitter',
        'Instagram' => 'bi bi-instagram',
        'LinkedIn' => 'bi bi-linkedin',
        'Pinterest' => 'bi bi-pinterest',
        'Threads' => 'bi bi-threads',
        'TikTok' => 'bi bi-tiktok',
        'Youtube' => 'bi bi-youtube'
    );

    $colores_redes_sociales = array(
        'Facebook' => 'background-color: #3b5998;',
        'Twitter' => 'background-color: #55acee;',
        'Instagram' => 'background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%);',
        'LinkedIn' => 'background-color: #0082ca;',
        'Pinterest' => 'background-color: #E60023;',
        'Threads' => 'background-color: #000;',
        'TikTok' => 'background-color: #000',
        'Youtube' => 'background-color: #FF0000'
    );


    // Verifica que haya enlaces disponibles
    if (!empty($redes_sociales) && is_array($redes_sociales)) {
        echo '<div class="redes-sociales-flotantes">';
        foreach ($redes_sociales as $nombre => $enlace) {
            if (!empty($enlace) && isset($iconos_redes_sociales[$nombre])) {
                // Genera botones flotantes con iconos para cada red social
                echo '<a href="' . esc_url($enlace) . '" class="btn text-white btn-floating m-1" style="' . esc_attr($colores_redes_sociales[$nombre]) . '" target="_blank">';
                echo '<i class="' . esc_attr($iconos_redes_sociales[$nombre]) . '"></i>';
                echo '</a>';
            }
        }
        echo '</div>';
    }
}

add_shortcode('botones_redes_sociales', 'botones_redes_sociales_shortcode');


//custom menu mobile

function mobile_menu_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'menu_class' => '',
        'menu_items' => '',
    ), $atts, 'mobile_menu' );

    // Obtener las categorías de los posts
    $categories = get_categories();

    // Buscar la categoría "Uncategorized" y obtener su ID
    $uncategorized_id = 1;
    $tips_id = 0;
    $recetas_id = 0;
    foreach ($categories as $category) {
        if ($category->name === 'Tips') {
            $tips_id = $category->term_id;
            continue;
        }
        if ($category->name === 'Recetas') {
            $recetas_id = $category->term_id;
            continue;
        }
    }
    
    // Convertir la lista de elementos del menú a un array de enlaces y títulos
    $menu_items = explode( ',', $atts['menu_items'] );

    // Generar el código HTML del menú móvil
    $output = '<nav class="' . esc_attr( $atts['menu_class'] ) . '">';
    $output .= '<div class="navbar-mobile">';
    $output .= '<div class="nav-container">';
    $output .= '<a href="'.esc_url(home_url()).'"><img class="logo" src="' . esc_url( (wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full'))[0]). '" alt="logo" /></a>';
    $output .= '<input class="checkbox" type="checkbox" name="" id="scrollCheckbox" />';
    $output .= '<div class="hamburger-lines">';
    $output .= '<span class="line line1"></span>';
    $output .= '<span class="line line2"></span>';
    $output .= '<span class="line line3"></span>';
    $output .= '</div>';
    $output .= '<div class="menu-items">';
	
	$output .= '<div class="menu-items-list">';
    $output .= '<li><a href="' . esc_url( home_url() ) . '">Inicio</a></li>';


    
    $orden = array(
        'Ensaladas y acompañamientos',
        'Entradas y sopas',
        'Masas y galletas',
        'Picoteo',
        'Platos de fondo',
        'Postres y tartas',
        'Snacks',
        'Bebidas sin alcohol',
        'Cocina peruana',
        'Cocina chilena',
        'Cocktails',
    );

    $ordered_categories = array();
    foreach ($orden as $nombre_categoria) {
        foreach ($categories as $category) {
            if ($category->name === $nombre_categoria) {
                $ordered_categories[] = $category;
                break;
            }
        }
    }

    // Si quedan categorías que no se incluyeron en el orden personalizado, agrégalas al final
    foreach ($categories as $category) {
        if (!in_array($category, $ordered_categories)) {
            $ordered_categories[] = $category;
        }
    }



    foreach ( $ordered_categories as $category ) {
        if ( $category->term_id !== $uncategorized_id ) {
            $output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
            // Verificar si hay submenús para esta categoría
            $submenus = get_categories( array( 'parent' => $category->term_id ) );
            if ( $submenus ) {
                $output .= '<ul class="submenu">';
                foreach ( $submenus as $submenu ) {
                    $output .= '<li><a href="' . esc_url( get_category_link( $submenu->term_id ) ) . '">' . esc_html( $submenu->name ) . '</a></li>';
                }
                $output .= '</ul>';
            }
            $output .= '</li>';
        }
    }
    if(get_option('nuestros_productos') != ''){
        $output .= '<li style="white-space:nowrap;">
        <a href="' . esc_url( get_option('nuestros_productos')) . '?utm_source=qblog">' . esc_html('Nuestros Productos') . '</a>
        </li>';

    }

	$output .= '</div>';


    $output .= lista_redes_sociales();

    
    
    $output .= '</div>';

    $output .= '<a href="#popup1" class="search-btn"><i class="fa fa-search"></i></a>';


    $output .= '<div id="popup1" class="overlay">
	<div class="popup">
		<a class="close-modal" href="#"><i class="fa fa-window-close"></i></a>
		<div class="content-popup">';

    $output .= do_shortcode('[custom_search_form]' );    
	$output .='		
		</div>
	</div>
</div>
    ';
    
    $output .= '</div>';

    
    $output .= '</div>';
    $output .= '</nav>';
    return $output;
}
add_shortcode( 'custom_mobile_menu', 'mobile_menu_shortcode' );

//custom menu mobile



function lista_redes_sociales() {
    // Recupera los enlaces de las redes sociales almacenados en la base de datos
    $redes_sociales = get_option('redes_sociales');


    $iconos_redes_sociales = array(
        'Facebook' => 'fab fa-facebook-f',
        'Twitter' => 'bi bi-twitter',
        'Instagram' => 'bi bi-instagram',
        'LinkedIn' => 'bi bi-linkedin',
        'Pinterest' => 'bi bi-pinterest',
        'Threads' => 'bi bi-threads',
        'TikTok' => 'bi bi-tiktok',
        'Youtube' => 'bi bi-youtube'
    );

    $colores_redes_sociales = array(
        'Facebook' => 'background-color: #3b5998;',
        'Twitter' => 'background-color: #55acee;',
        'Instagram' => 'background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%);',
        'LinkedIn' => 'background-color: #0082ca;',
        'Pinterest' => 'background-color: #E60023;',
        'Threads' => 'background-color: #000;',
        'TikTok' => 'background-color: #000',
        'Youtube' => 'background-color: #FF0000'
    );


    $return = '';

    // Verifica que haya enlaces disponibles
    if (!empty($redes_sociales) && is_array($redes_sociales)) {
        $return .= '<div>';
        foreach ($redes_sociales as $nombre => $enlace) {
            if (!empty($enlace) && isset($iconos_redes_sociales[$nombre])) {
                // Genera un elemento de lista con icono de Bootstrap Icons para cada red social
                $return .= '<a class="btn text-white btn-floating m-1" href="' . esc_url($enlace) . '" style="' . esc_attr($colores_redes_sociales[$nombre]) . '" target="_blank">';
                $return .= '<i class="' . esc_attr($iconos_redes_sociales[$nombre]) . '"></i>';
                $return .= '</a>';
            }
        }
        $return .= '</div>';
    }

    return $return;
}