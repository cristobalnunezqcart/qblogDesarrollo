<!-- dev.to/erhankilic/adding-infinite-scroll-without-plugin-to-wordpress-theme-595a -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<!-- timeline time label -->
<li class="time-label">
    <span class="bg-green"><?php the_time('d.m.Y ') ?></span>
</li>
<!-- /.timeline-label -->
<!-- timeline item -->
<li>
    <i class="fa fa-newspaper-o bg-blue"></i>
    <div class="timeline-item">
        <span class="time"><i class="fa fa-clock-o"></i> <?php the_time('H:i') ?></span>
        <h3 class="timeline-header"><a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?> "><?php the_title(); ?></a></h3>
        <div class="timeline-body">
            <div class="row">
                <div class="col-lg-3 col-sm-4 col-xs-6">
                     <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                     <?php $resim_yolu = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium'); if ( has_post_thumbnail() ) { ?>

                         <img src="<?php echo $resim_yolu[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>" title="<?php the_title() ?>" />
                     <?php } ?>
                     </a>
                 </div>
                <div class="col-lg-9 col-sm-8 col-xs-6">
                     <?php the_excerpt_rss(); ?>
                     <div style="margin-top: 10px">
                         <a class="btn btn-primary btn-xs" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">Read more</a>
                     </div>
                </div>
           </div>
       </div>
       <div class="timeline-footer">
             <i class="fa fa-user"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?></a> | <i class="fa fa-folder-open"></i> <?php the_category(', ') ?> | <i class="fa fa-comments"></i> <?php comments_number('0 comment', '1 comment', '% comments' );?>
         </div>
     </div>
</li>
<!-- END timeline item -->
<?php endwhile; ?>
<?php endif; ?>