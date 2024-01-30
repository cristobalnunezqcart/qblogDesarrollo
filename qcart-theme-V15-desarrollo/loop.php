<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php include 'template-parts/content.php';?>

<?php endwhile; ?>
<?php endif; ?>