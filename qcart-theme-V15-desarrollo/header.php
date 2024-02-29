<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package qcart-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> style="height: 100%">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800;1,6..12,900;1,6..12,1000&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,500,0,0" />
	<link rel="stylesheet" href="https://use.typekit.net/eap4nrj.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<?php wp_head();
 	echo do_shortcode( '[custom_elementor_shape]' );
	 ?>
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" crossorigin="anonymous"></script>
	<link href="<?php bloginfo( 'template_url' ); ?>/css/swiper.min.css" rel="stylesheet">
	<script src="<?php bloginfo( 'template_url' ); ?>/js/swiper.min.js"></script>
	<script type="module" src="<?php bloginfo( 'template_url' ); ?>/js/swiper-option.js"></script>

	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'qcart-theme' ); ?></a>

	<header id="masthead" class="site-header">
	<section class="header-flex-box">
		<div class="columns-flexbox">
			<div class="main-flexbox">
				<div class="rows-flexbox">
					<?php echo do_shortcode( '[custom_search_form]' ); ?>
					<?php echo do_shortcode( '[custom_menu]' ); ?>
				</div>
			</div>
		<aside class="sidebar-first"><?php the_custom_logo(); ?></aside>
		<aside class="sidebar-second">
		
		<?php 
		if(get_option('nuestros_productos') != ''){
			echo '<a href="' . esc_url( get_option('nuestros_productos')) . '?utm_source=qblog" style="display: inline-flex; align-items: center; text-decoration: none; color: #000; padding: 5px 10px; border: 1px solid #ccc; border-radius: 100px; border-color:var(--color-primary);">
			<span style="margin-right: 10px; ">
				<span style="margin-right: 10px;">Nuestros Productos</span>
				<i class="bi bi-box-arrow-right"></i>
			</a>';
		}
		?>
		<?php echo do_shortcode( '[botones_redes_sociales]' ); ?> </aside>
			<?php
			if ( is_front_page() && is_home() ) :
				?>
				<!--
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				-->
				<?php
			else :
				?>
				<!--
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				-->
				<?php
			endif;
			$qcart_theme_description = get_bloginfo( 'description', 'display' );
			if ( $qcart_theme_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $qcart_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div>
		</section><!-- .site-branding -->
			<!-- permite agregar custom widgets al header -->
			<?php if (is_active_sidebar('custom_widgets_area')) : ?>
					<div id="custom-widgets" class="custom-widgets-area">
							<?php dynamic_sidebar('custom_widgets_area'); ?>
					</div>
			<?php endif; ?>
		<!--
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				☰
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav>--><!-- #site-navigation -->
	</header><!-- #masthead -->
