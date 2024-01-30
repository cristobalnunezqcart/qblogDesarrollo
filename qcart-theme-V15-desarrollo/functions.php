<?php
/**
 * qcart-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package qcart-theme
 */

require get_template_directory() . '/inc/backend-functions.php';
require get_template_directory() . '/inc/frontend-functions.php';
require get_template_directory() . '/inc/banner.php';

define('DISALLOW_FILE_EDIT', false);
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}



/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function qcart_theme_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on qcart-theme, use a find and replace
     * to change 'qcart-theme' to the name of your theme in all the template files.
     */
    load_theme_textdomain('qcart-theme', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'qcart-theme'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'qcart_theme_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );

}


// Función para inicializar las opciones de Qcategorías
function qcart_theme_categories_initialize() {
    if (false === get_option('qcart_theme_categories_options')) {
        $new_options = array(
            array('category' => 'Picoteo', 'keywords' => 'picoteo, tequeño, aperitivos, dip'),
            array('category' => 'Snacks', 'keywords' => 'colaciones, barritas de cereal, snacks, colación, snack'),
            array('category' => 'Entradas y sopas', 'keywords' => 'sopa, entrada, caldo, crema'),
            array('category' => 'Ensaladas y acompañamientos', 'keywords' => 'ensalada, acompañamiento, guarnición, aderezo'),
            array('category' => 'Platos de fondo', 'keywords' => 'plato de fondo, charquican, charquicán, lasagna, lasaña, pizza, tallarines, plato principal, risotto, principal, segundo plato, carne, pollo, pollito, pescado, Fetuccini, carbonada, causa'),
            array('category' => 'Cocina peruana', 'keywords' => 'cocina peruana, comida peruana, recetas peruanas'),
            array('category' => 'Cocina chilena', 'keywords' => 'cocina chilena, comida chilena, recetas chilenas, Mote con Huesillo'),
            array('category' => 'Masas y galletas', 'keywords' => 'masas, bollería, galletas, quequito, galletitas, queque, queques, bizcocho, bizcochito, brownies, brownie, empolvado, pancakes, churro, churros'),
            array('category' => 'Postres y tartas', 'keywords' => 'kuchen, tarta, postre, pie, gelatina, flan, panqueque, tiramisú, tiramisu, suspiro limeño'),
            array('category' => 'Cocktails', 'keywords' => 'trago, licor, coctel, mojito, margarita, piña colada, pisco, vodka, ron, Apple Spritz, Apple Mule, Apple Ginger, Gentleman Sour, Spritz, Gin Tonic, Jack Apple, whiskey, whisky'),
            array('category' => 'Bebidas sin alcohol', 'keywords' => 'smoothie, mocktails, leche con plátano, café, cafés')
        );
        //add_option('qcart_theme_categories_options', array());
        update_option('qcart_theme_categories_options', $new_options);

    }
    add_settings_section(
        'qcart_theme_categories_section',
        'Filas de Categorías',
        'qcart_theme_categories_section_callback',
        'qcart_theme_categories_options'
    );
    register_setting('qcart_theme_categories_options', 'qcart_theme_categories_options', 'qcart_theme_sanitize_categories_options');
    register_setting('qcart_theme_categories_options', 'double_category_option','qcart_theme_sanitize_categories_options');
}
add_action('admin_init', 'qcart_theme_categories_initialize');

// Callback para la sección de categorías
function qcart_theme_categories_section_callback() {
    echo '<p>Aquí puedes agregar categorías y palabras clave, recuerda que las palabras claves se buscarán con Hashtags dentro del post, por lo que se debe colocar sin hashtag en el listado de palabras claves.</p>';
    
    $double_category_option = get_option('double_category_option');
    
    $options = get_option('qcart_theme_categories_options');
    ?>
    <style>
        .loading-overlay {
            display: none;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3); /* Color del borde del spinner */
            border-top: 4px solid #ffffff; /* Color de la parte superior del spinner */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div>
        <br>
        <label for="checkbox_categoria">¿Doble Categoría?</label>
        <input type="checkbox" id="checkbox_categoria" name="double_category_option" <?php checked($double_category_option, 'true'); ?> value="true" />


    </div>

    <table class="form-table qcart-theme-categories-table">
        <tr>
            <th>Categoría</th>
            <th>Palabras Clave</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (!empty($options)) {
            foreach ($options as $key => $option) {
                ?>
                <tr>
                    <td>
                        <input type="text" name="qcart_theme_categories_options[<?php echo $key; ?>][category]" value="<?php echo esc_attr($option['category']); ?>" />
                    </td>
                    <td>
                        <input type="text" name="qcart_theme_categories_options[<?php echo $key; ?>][keywords]" value="<?php echo esc_attr($option['keywords']); ?>" />
                    </td>
                    <td>
                        <button type="button" class="button remove-row-button">Eliminar</button>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <button class="button" id="add-row-button">Nueva Fila</button>
    <script>
        jQuery(document).ready(function($) {
            var index = <?php echo count($options); ?>;
            $('#add-row-button').on('click', function(e) {
                e.preventDefault();
                $('<tr>' +
                    '<td><input type="text" name="qcart_theme_categories_options[' + index + '][category]" value="" /></td>' +
                    '<td><input type="text" name="qcart_theme_categories_options[' + index + '][keywords]" value="" /></td>' +
                    '<td><button type="button" class="button remove-row-button">Eliminar</button></td>' +
                    '</tr>').appendTo('.qcart-theme-categories-table');
                index++;
            });

            $('.qcart-theme-categories-table').on('click', '.remove-row-button', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    <?php
}

// Función para sanitizar las opciones de Qcategorías
function qcart_theme_sanitize_categories_options($input) {
    $output = array();
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $output[$key]['category'] = sanitize_text_field($value['category']);
            $output[$key]['keywords'] = sanitize_text_field($value['keywords']);
        }
    }

    // Sanitizar double_category_option
    if (isset($input['double_category_option'])) {
        $output['double_category_option'] = $input['double_category_option'];
    }

    return $output;
}

function qcart_theme_enqueue_scripts() {
    wp_enqueue_script('qcart-theme-ajax', get_template_directory_uri() . '/js/qcart-theme-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('qcart-theme-ajax', 'qcart_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('qcart_theme_recategorize_posts'),
    ));
}
add_action('admin_enqueue_scripts', 'qcart_theme_enqueue_scripts');

function qcart_theme_recategorize_posts() {
    //check_ajax_referer('qcart_theme_recategorize_posts', 'nonce');
    qcart_theme_remove_all_categories_from_posts();
    qcart_theme_delete_all_categories();
    global $wpdb;

    $options = get_option('qcart_theme_categories_options');

    if (empty($options)) {
        wp_send_json_error(array('message' => 'No se han agregado categorías y palabras clave.'));
    }

    $subqueries = array();
    foreach ($options as $option) {
        $category = $option['category'];
        $keywords = explode(',', $option['keywords']);
    
        $keywordConditions = array();
        foreach ($keywords as $keyword) {
            //$keyword = $wpdb->esc_like(strtolower(trim($keyword)));
            $keyword = preg_replace("/[^a-zA-Z0-9#\s]/", "", $keyword);
            $keyword = $wpdb->esc_like(strtolower(trim($keyword)));
            $keywordConditions[] = "(LOWER(p.post_content) LIKE '% $keyword %')";
        }
    
        $subquery = "
            SELECT p.ID, '$category' AS new_category
            FROM $wpdb->posts AS p
            WHERE p.post_type = 'post' AND (" . implode(' OR ', $keywordConditions) . ")
        ";
    
        $subqueries[] = $subquery;
    }

    $subquery = "
        SELECT p.ID, 'Tips' AS new_category
        FROM $wpdb->posts AS p
        WHERE p.post_type = 'post' AND (
            LOWER(p.post_content) LIKE '% tip %' OR
            LOWER(p.post_title) LIKE '% tip %' OR
            LOWER(p.post_title) LIKE '% tips %' OR
            LOWER(p.post_content) LIKE '% tips %'
        )
    ";

    $subqueries[] = $subquery;

    $sql = "
        SELECT p.ID, COALESCE(MAX(sub.new_category), '') AS new_category, LOWER(p.post_content) AS post_content
        FROM $wpdb->posts AS p
        LEFT JOIN (" . implode(' UNION ', $subqueries) . ") AS sub ON p.ID = sub.ID
        WHERE p.post_type = 'post'
        GROUP BY p.ID, p.post_content
    ";

    // Ejecutar la consulta
    $results = $wpdb->get_results($sql);

    if (empty($results)) {
        wp_send_json_error(array('message' => 'No se encontraron posts que coincidan con las palabras clave.'));
    }

    // Recategorizar los posts con al menos 3 coincidencias de regex
    foreach ($results as $result) {
        $post_id = $result->ID;
        $new_category = $result->new_category;
        $post_content = $result->post_content;

        if($new_category != 'Tips'){
            // Aplicar regex para buscar al menos 3 coincidencias


            $regex = '/(?im)^[^A-zÀ-ÿ0-9]*(\d+|(una?|dos|tres|cuatro|cinco|seis|siete|ocho|nueve|diez|once|doce|trece|catorce|quince|medi[ao]s?|la\s+mitad|cuart[ao]|onzas?|g|gramos?|kgs?|kilos?|kilogramo?s?|ta?zas?|cdas?|cucharadas?)\s+)\s*(?![-.]\s*\b\w+\b)[^\n]*[A-zÀ-ÿ]/';

            preg_match_all($regex, $post_content, $matches);
            $num_matches = count($matches[0]);

            if(!$new_category){
                wp_trash_post($post_id);
                continue;
            }

            if (stripos($post_content, 'ingredientes:') === false) {
                if ($num_matches < 2) {
                    wp_trash_post($post_id);
                    continue;
                }   
            }
        }

        // Verificar si la categoría existe o crearla
        if (!term_exists($new_category, 'category')) {
            $term = wp_insert_term($new_category, 'category');
            if (is_wp_error($term)) {
                continue; // Salta a la siguiente iteración si ocurre un error al crear la categoría
            }
            $category_id = $term['term_id'];
        } else {
            $category_id = get_cat_ID($new_category);
        }

        // Eliminar las categorías previas del post
        $previous_categories = wp_get_post_categories($post_id);
        foreach ($previous_categories as $previous_category) {
            wp_remove_object_terms($post_id, $previous_category, 'category');
        }
        
        // Asignar la nueva categoría al post
        wp_set_post_categories($post_id, array($category_id), true);
        remove_action( 'save_post', 'qcart_theme_recategorize_single_post');
        wp_update_post(array('ID' => $post_id, 'post_status' => 'publish'));
        add_action( 'save_post', 'qcart_theme_recategorize_single_post');

    }
    $categories = get_categories();
    foreach ($categories as $category) {
        wp_update_term_count($category->term_id, 'category');
    }
    wp_send_json_success(array('message' => 'Se han recategorizado los posts exitosamente.'));
}
add_action('wp_ajax_qcart_theme_recategorize_posts', 'qcart_theme_recategorize_posts');
//add_action('wp_ajax_nopriv_qcart_theme_recategorize_posts', 'qcart_theme_recategorize_posts');







//resetear categorías de posts
function qcart_theme_remove_all_categories_from_posts() {
    global $wpdb;

    // Consulta para desasignar todas las categorías de los posts
    $sql = "
        DELETE tr
        FROM $wpdb->term_relationships AS tr
        INNER JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        WHERE tt.taxonomy = 'category'
    ";

    $wpdb->query($sql);
}


//resetear categorías de posts


//resetear categorías globales

function qcart_theme_delete_all_categories() {
    $args = array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    );

    $categories = get_categories($args);

    if ($categories) {
        foreach ($categories as $category) {
            wp_delete_term($category->term_id, 'category');
        }
    }

    return true;
}

//resetear categorías globales


add_action('after_setup_theme', 'qcart_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function qcart_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('qcart_theme_content_width', 640);
}
add_action('after_setup_theme', 'qcart_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function qcart_theme_widgets_init() {
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'qcart-theme'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'qcart-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );

    // Permite añadir widgets al header de la página
    register_sidebar(
        array(
            'name' => esc_html__('Header Custom Widgets Area ', 'qcart-theme'),
            'id' => 'custom_widgets_area',
            'description' => esc_html__('Add widgets here for custom area', 'qcart-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action('widgets_init', 'qcart_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function qcart_theme_scripts()
{
    wp_enqueue_style('qcart-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('qcart-theme-style', 'rtl', 'replace');

    wp_enqueue_script('qcart-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'qcart_theme_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

// dev.to/erhankilic/adding-infinite-scroll-without-plugin-to-wordpress-theme-595a
//Infinite Scroll
function wp_infinitepaginate()
{
    $loopFile = $_POST['loop_file'];
    $paged = $_POST['page_no'];
    $action = $_POST['what'];
    $value = $_POST['value'];
    $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';

    if ($action == 'author_name') {
        $arg = array('author_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    } elseif ($action == 'category_name') {
        $arg = array('category_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    } elseif ($action == 'search') {
        $arg = array('s' => $search_query, 'paged' => $paged, 'post_status' => 'publish');
    } else {
        $arg = array('paged' => $paged, 'post_status' => 'publish');
    }

    # Load the posts
    query_posts($arg);
    get_template_part($loopFile);

    exit;
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate'); // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate'); // if user not logged in

// parrotcreative.co.uk/cookies-blocked-or-not-supported-by-browser
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if (SITECOOKIEPATH != COOKIEPATH) {
    setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);
}

function enqueue_custom_scripts() {
    wp_enqueue_script( 'custom-search', get_template_directory_uri() . '/js/custom-search.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'custom-search', 'custom_search_params', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'custom-search-nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );


function custom_search_form_shortcode() {
    ob_start();
    ?>
    <div class="custom-search-form-container">
        <form role="search" method="get" class="search-form" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'qcart-theme' ); ?></span>
                <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Buscar Ingrediente o Receta  &hellip;', 'placeholder', 'qcart-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
            <button type="submit" class="search-submit"><?php echo esc_attr_x( 'Buscar', 'submit button', 'qcart-theme' ); ?></button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_search_form', 'custom_search_form_shortcode' );



function custom_search() {
    check_ajax_referer( 'custom-search-nonce', 'nonce' );

    $search_query = sanitize_text_field( $_POST['search_query'] );

    // Realiza la búsqueda de posts con la consulta recibida
    $args = array(
        's' => $search_query,
        'post_type' => 'post', // O el tipo de post que desees buscar
    );

    $search_results = new WP_Query( $args );

    if ( $search_results->have_posts() ) {
        while ( $search_results->have_posts() ) {
            $search_results->the_post();
            // Aquí puedes mostrar los resultados de búsqueda de la manera que desees
            get_template_part( 'template-parts/content' );
        }
    } else {
        // Si no hay resultados, muestra un mensaje
        echo 'No se encontraron resultados.';
    }

    wp_reset_postdata();
    wp_die();
}
add_action( 'wp_ajax_custom_search', 'custom_search' );
add_action( 'wp_ajax_nopriv_custom_search', 'custom_search' );



//custom menu

function custom_menu_output() {
    ob_start();
    ?>
    <nav class="custom-menu">
        <ul>
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
            <li class="has-dropdown">
                <?php
                // Obtener las categorías de los posts excluyendo la categoría con el identificador "tips"
                $categories = get_categories(array('exclude' => '126,127'));

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
                echo '<a href="' . esc_url(get_category_link($recetas_id)) . '">Recetas</a>';

                if ($categories) {
                    echo '<ul class="dropdown">';


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



                    foreach ($ordered_categories as $category) {
                        if ($category->term_id !== $uncategorized_id && $category->term_id !== $tips_id && $category->term_id !== $recetas_id) {
                            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
                
                if($tips_id){
                    echo '<li><a href="' . esc_url(get_category_link($tips_id)) . '">' . esc_html('Tips') . '</a></li>';
                }
                ?>
            </li>

            <li class="has-dropdown">
                <?php
                // Obtener las categorías de los posts excluyendo la categoría con el identificador "tips"
                $categories = get_categories(array('exclude' => '129,132,130,128,131'));

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
                echo '<a href="' . esc_url(get_category_link($recetas_id)) . '">Tips</a>';

                if ($categories) {
                    echo '<ul class="dropdown">';


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



                    foreach ($ordered_categories as $category) {
                        if ($category->term_id !== $uncategorized_id && $category->term_id !== $tips_id && $category->term_id !== $recetas_id) {
                            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
                ?>
            </li>
            <!--
            <li><a href="<?php echo esc_url(home_url('/contacto/')); ?>">Contacto</a></li>
            -->
        </ul>
    </nav>

    <!-- Agrega el botón de hamburguesa para versión móvil -->
    <div class="menu-toggle">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <br>        
    <?php
    return ob_get_clean();
}
add_shortcode('custom_menu', 'custom_menu_output');

//custom menu

//recategorizar post al guardar o crear

function qcart_theme_recategorize_single_post($post_id) {
    if (wp_is_post_autosave($post_id)) return;

    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'untrash'){
        return;
    }

	//agregar opción de doble categoría
    $options = get_option('qcart_theme_categories_options');

    if (empty($options) ) {
        return; // No se han agregado categorías y palabras clave, no se hace nada
    }

    $parent_id = wp_is_post_revision( $post_id );

    if ( false !== $parent_id ) {
        $post_id = $parent_id;
    }

    remove_action('save_post', 'qcart_theme_recategorize_single_post');
    $post = get_post($post_id);
    $post_content = strtolower($post->post_content);

    $pattern = '/\bhttps?:\/\/\S+/i'; // Encontrar URLs

    // Reemplazamos todas las URLs encontradas por una cadena vacía
    $post_content = preg_replace($pattern, '', $post_content);

    $post_title = strtolower($post->post_title);

    //$new_category = '';
    $new_category = array();
    $num_categories_post = 0;

    // Verificar si el post contiene "tip" o "tips"
    if (stripos($post_content, '#tip') !== false || stripos($post_content, '#tips') !== false ) {

        array_push($new_category,"Tips");
        $num_categories_post++;

    } else {
        
        $num_matches = 0;
 
        $regex = '/(?im)^[^A-zÀ-ÿ0-9]*(\d+|(una?|dos|tres|cuatro|cinco|seis|siete|ocho|nueve|diez|once|doce|trece|catorce|quince|medi[ao]s?|la\s+mitad|cuart[ao]|onzas?|g|gramos?|kgs?|kilos?|kilogramo?s?|ta?zas?|cdas?|cucharadas?)\s+)\s*(?![-.]\s*\b\w+\b)[^\n]*[A-zÀ-ÿ]/';


        

        foreach ($options as $option) {
            $category = $option['category'];
            $keywords = explode(',', $option['keywords']);
            foreach ($keywords as $keyword) {
                
                if (stripos($post_title, ltrim($keyword) ) !== false || stripos($post_content, ltrim($keyword) ) !== false) {
                    
                    if($category == 'Tips' && !in_array($category,$new_category)){
                        array_push($new_category, "Tips" );
                        $num_categories_post++;
                        if($num_categories_post === 2){
                            break 2;
                        }else{
                            continue 2;
                        }  
                        
                    }


                    if (stripos($post_content, 'ingredientes:') !== false) {
                        array_push($new_category, $category );
                        $num_categories_post++;
                        if($num_categories_post === 2){
                            break 2;
                        }else{
                            continue 2;
                        }  
                    }

                    $matches = array();
                    preg_match_all($regex, $post_content, $matches);
                    $num_matches = count($matches[0]);
                    if ($num_matches >= 2) {
                        array_push($new_category, $category );
                        $num_categories_post++;
                        if($num_categories_post === 2){
                            break 2;
                        }else{
                            continue 2;
                        }      
                    }else{
                        break 2;    
                    }
                }
            }
        }
    }

    // Verificar si la categoría existe o crearla
    if (!empty($new_category)) {

        $categories = wp_get_post_categories($post_id);
        foreach ($categories as $category_id) {
            wp_remove_object_terms($post_id, $category_id, 'category');
        }

        foreach ($new_category as $nueva_categoria){


        if (!term_exists($nueva_categoria, 'category')) {
            $term = wp_insert_term($nueva_categoria, 'category');
            if (is_wp_error($term)) {
                add_action('save_post', 'qcart_theme_recategorize_single_post');
                return;
            }else{
                $new_category_id = $term['term_id'];
            }
        }else{
            $new_category_id = get_cat_ID($nueva_categoria);
        }

        if ($new_category_id) {
            wp_set_post_categories($post_id, array($new_category_id), true);
            add_action('save_post', 'qcart_theme_recategorize_single_post');
        }

    }

    return;
        
    }else{
        wp_trash_post($post_id);
        add_action('save_post', 'qcart_theme_recategorize_single_post');
        return;
    }

}

add_action('save_post', 'qcart_theme_recategorize_single_post');


//recategorizar post al guardar o crear

function auto_link_keywords($content) {
    $keywords = array(
        '@elherborista' => 'https://www.instagram.com/elherborista/',
        // Agrega más palabras clave y enlaces según sea necesario
    );

    foreach ($keywords as $keyword => $link) {
        $content = preg_replace('/\b' . $keyword . '\b/i', '<a href="' . $link . '">' . $keyword . '</a>', $content);
    }

    return $content;
}


add_filter('the_content', 'auto_link_keywords');



function enqueue_bootstrap() {
    // Cargar el CSS de Bootstrap 5 (desde la CDN)
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function copiar_categoria_a_meta_tag() {
    global $post;

    // Verifica si es una entrada y tiene categorías asignadas
    if (is_single() && has_category()) {
        $categorias = get_the_category($post->ID);

        // Obtiene la primera categoría asignada
        $categoria = reset($categorias);

        // Si la categoría no está vacía, la copia a la etiqueta meta
        if (!empty($categoria->name)) {
            echo '<meta name="keywords" content="' . esc_attr($categoria->name) . '" />';
        }
    }
}
add_action('wp_head', 'copiar_categoria_a_meta_tag');

function detectar_arroba_y_enlazar_instagram($content) {
    // Define el patrón regex para buscar el arroba seguido de texto
    $patron = '/@([a-zA-Z0-9_]+)/';

    // Sustituye los arrobas encontrados por una URL de perfil de Instagram
    $nuevo_contenido = preg_replace($patron, '<a href="https://www.instagram.com/$1" target="_blank">@$1</a>', $content);

    // Devuelve el contenido modificado
    return $nuevo_contenido;
}

// Aplica la función a la salida del contenido
add_filter('the_content', 'detectar_arroba_y_enlazar_instagram');

