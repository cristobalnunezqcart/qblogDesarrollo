<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package qcart-theme
 */
get_header();
echo do_shortcode( '[qbanner]' );
echo do_shortcode( '[qbanner_mobile]' );
echo do_shortcode( '[custom_mobile_menu]' );
?>
<div style="height: 2dvh; display: block;"></div>


<div class="section-title text-center mb-4">
    <h1 class="display-4 font-weight-bold">Recetas</h1>
    </br style="margin-top: 0;">
    <h2 class="lead_title">
    <?php
    $home_page_subtitulo = get_option('home_page_subtitulo');
    if (!empty($home_page_subtitulo)) {
        echo esc_html($home_page_subtitulo);
    } else {
        echo 'Explora nuestras recetas únicas y sabrosas para disfrutar en casa.';
    }
    ?>
    </h2>
</div>

<div class="swiper-outer-container">
    <div class="swiper-inner-container">
        <div class="swiper-container swiper2">
            <div class="swiper-wrapper">
                <?php
                $exclude_categories = array(1); // Coloca aquí las IDs de las categorías a excluir, NO APARECEN en los CIRCULOS!!!
                $categories = get_categories(array(
                    'exclude' => $exclude_categories,
                    'orderby' => 'term_order', // Ordena según el orden establecido con el plugin
                ));


                // Itera a través de las categorías
                foreach ($categories as $category) {
                    $category_name = $category->name; // Nombre de la categoría
                    $category_image_url = get_option('qcart_theme_category_images')[$category->cat_ID] ?? '';

                    if (empty($category_image_url)) {
                    switch ($category_name) {
                        case 'Picoteo':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/picoteo.webp';
                            break;
                        case 'Snacks':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/snacks.webp';
                            break;
                        case 'Entradas y sopas':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/sopa.webp';
                            break;
                        case 'Ensaladas y acompañamientos':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/ensaladas.webp';
                            break;
                        case 'Platos de fondo':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/fetuccini.webp';
                            break;
                        case 'Cocina peruana':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/cocina_peruana.webp';
                            break;
                        case 'Cocina chilena':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/cocina_chilena.webp';
                            break;
                        case 'Masas y galletas':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/postre2_1.webp';
                            break;
                        case 'Postres y tartas':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/postre.webp';
                            break;
                        case 'Cocktails':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/alcohol.webp';
                            break;
                        case 'Bebidas sin alcohol':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/bebidas_sin_alcohol.webp';
                            break;
                        case 'Tips':
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/tip.webp';
                            break;                   
                        default:
                            $category_image_url = get_template_directory_uri() . '/assets/img/categories/alcohol.webp';
                            break;
                        }
                    }
                    ?>
                    <div class="swiper-slide swiperslide2">
                        <a style="text-decoration:none; color:#000; text-align: center;" href="<?php echo esc_url(get_category_link($category->cat_ID)); ?>">
                            <div class="category-image">
                                <img src="<?php echo $category_image_url; ?>" alt="<?php echo esc_attr($category_name); ?>">
                            </div>
                            <p class="category-name"><?php echo $category_name; ?></p>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="swiper-button-prev swiper-button-prev2"></div> <!-- Botón de retroceso -->
        <div class="swiper-button-next swiper-button-next2"></div> <!-- Botón de avance -->
    </div>
</div>

<br>
<div class="banner-especial">
  <a href="https://google.com">
    <img src="https://img.freepik.com/foto-gratis/retrato-abstracto-ojo-elegancia-mujeres-jovenes-generado-ai_188544-9712.jpg?size=626&ext=jpg&ga=GA1.1.1687694167.1703808000&semt=ais" alt="Descripción del Banner">
  </a>
</div>
<br>
<main id="primary" class="site-main"></main>


<?php
get_footer();
?>