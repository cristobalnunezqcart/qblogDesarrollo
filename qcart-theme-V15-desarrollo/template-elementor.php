<?php
/**
 * Template Name: Página de Elementor
 * @package qcart-theme
 */

get_header();

// Obtén el contenido de Elementor
$content = get_post_meta(get_the_ID(), '_elementor_edit_mode', true);

if (!empty($content)) {
   echo $content;
}

get_footer();