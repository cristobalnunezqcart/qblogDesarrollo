<!-- dev.to/erhankilic/adding-infinite-scroll-without-plugin-to-wordpress-theme-595a -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php include 'template-parts/content.php';?>

<?php endwhile; ?>
<?php endif; ?>