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
//echo do_shortcode( '[qbanner]' );
//echo do_shortcode( '[qbanner_mobile]' );
echo do_shortcode( '[custom_mobile_menu]' );
?>

<?php
// Obtén el slug de la categoría actual
$category_slug = get_queried_object()->slug;

// Utiliza el slug para obtener el nombre de la categoría
$category = get_term_by('slug', $category_slug, 'category');
$category_name = $category->name;
?>

<div class="container-fluid bg-light p-3 categoria-nombre">
    <div class="row">
        <div class="col-2">
            <a href="javascript:history.back()" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Atrás
            </a>
        </div>
        <div class="col-8 text-center">
          <h2 class="category-title"><?php echo ucwords($category_name); ?></h2>
        </div>
    </div>
</div>

<?php if (is_category('recetario')) : ?>
<div class="banner-recetario">
  <button id="abrirModalBtn">Abrir Formulario</button>
</div>

<!-- Modal -->
<div id="miModal" class="modal-recetario">
  <div class="modal-contenido">
    <span class="cerrar-modal" id="cerrarModalBtn">&times;</span>
    <h2>Formulario</h2>

    <form action="#" method="post">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" name="nombre" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <form action="#" method="post">
      <!-- Tu formulario aquí -->
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <button type="submit">Enviar</button>
    </form>
  </div>
</div>
<?php endif; ?>

<main id="primary" class="site-main"></main>


<?php
get_footer();
?>