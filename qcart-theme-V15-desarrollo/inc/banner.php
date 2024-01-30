<?php


/**
 * banner_loop_func_desktop
 *
 * Shortcode de banner loop
 * el cual utiliza los IDS de las imagenes guardadas
 * en base de datos
 * 
 * @author Javier Perez Silva
 * @param  mixed $atts
 * @return void
 */
function banner_loop_func_desktop( $atts ) {
    ob_start();
    $gallery_ids = get_option('gallery_ids_desktop');
    if ($gallery_ids) { ?>
        <div class="swiper banner desktop">
            <div class="swiper-wrapper">
                <?php foreach ($gallery_ids as $image_id) :
                    $image_url = wp_get_attachment_url($image_id);
                    $image_alt = get_the_title($image_id); ?>
                    <div class="swiper-slide"> 
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    <?php
    }
    $myvariable = ob_get_clean();
    return $myvariable;
}
add_shortcode( 'qbanner', 'banner_loop_func_desktop' );


function testimonial_loop_func_mobile( $atts ) {
    ob_start();
    $gallery_ids = get_option('gallery_ids_mobile');
    if ($gallery_ids) { ?>
        <div class="swiper banner mobile">
            <div class="swiper-wrapper">
                <?php foreach ($gallery_ids as $image_id) :
                    $image_url = wp_get_attachment_url($image_id);
                    $image_alt = get_the_title($image_id); ?>
                    <div class="swiper-slide"> 
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
        <div style="border-bottom:.1px solid rgb(219, 219, 219);"></div>
    <?php
    }else{
        ?>
            <div class="banner-separador" style="height: 10dvh;display: none;"></div>
        <?php
    }
    $myvariable = ob_get_clean();
    return $myvariable;
}
add_shortcode( 'qbanner_mobile', 'testimonial_loop_func_mobile' );


// Banner Slider Option Page Callback
function testimonial_slider_page_callback() {
    ?>
    <div class="wrap">
        <h2>Banner</h2>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <?php wp_nonce_field( 'update_testimonial_slider' ); ?>
            <input type="hidden" name="action" value="update_testimonial_slider">
            <div class="form-group">
                <label for="gallery_ids_desktop">Desktop</label>
                <select multiple name="gallery_ids_desktop[]" id="gallery_ids_desktop">
                    <?php
                    $images = get_children( array( 'post_type' => 'attachment', 'numberposts' => -1 ) );
                    $selected_ids = get_option( 'gallery_ids_desktop', array() );
                    foreach( $images as $image ) {
                        $selected = in_array( $image->ID, $selected_ids ) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $image->ID; ?>" <?php echo $selected; ?>><?php echo $image->post_title; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="gallery_ids_mobile">Mobile</label>
                <select multiple name="gallery_ids_mobile[]" id="gallery_ids_mobile">
                    <?php
                    $images = get_children( array( 'post_type' => 'attachment', 'numberposts' => -1 ) );
                    $selected_ids = get_option( 'gallery_ids_mobile', array() );
                    foreach( $images as $image ) {
                        $selected = in_array( $image->ID, $selected_ids ) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $image->ID; ?>" <?php echo $selected; ?>><?php echo $image->post_title; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Save" class="button button-primary">
        </form>
    </div>
    
    <?php
}

// Update Testimonial Slider Option
function update_testimonial_slider() {
    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update_testimonial_slider' ) ) {
        return;
    }

    if ( isset( $_POST['gallery_ids_desktop'] ) ) {
        $gallery_ids_desktop = array_map( 'intval', $_POST['gallery_ids_desktop'] );
        update_option( 'gallery_ids_desktop', $gallery_ids_desktop );
    }

    if ( isset( $_POST['gallery_ids_mobile'] ) ) {
        $gallery_ids_mobile = array_map( 'intval', $_POST['gallery_ids_mobile'] );
        update_option( 'gallery_ids_mobile', $gallery_ids_mobile );
    }

    wp_safe_redirect( admin_url( 'admin.php?page=testimonial_slider' ) );
    exit;
}
add_action( 'admin_post_update_testimonial_slider', 'update_testimonial_slider' );