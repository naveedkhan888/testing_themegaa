<?php 

if(!class_exists('WooCommerce')) return;

add_action('themename_woocommerce_group_buttons', 'themename_the_quick_view', 20, 1);
add_action('themename_woocommerce_group_buttons', 'themename_the_yith_compare', 30, 1);
add_action('themename_woocommerce_group_buttons', 'themename_the_yith_wishlist', 40, 1);

if ( ! function_exists( 'themename_woocommerce_setup_size_image' ) ) {
    function themename_woocommerce_setup_size_image() {
        $thumbnail_width = 480;
        $main_image_width = 800; 
        $cropping_custom_width = 1;
        $cropping_custom_height = 1.33;

        // Image sizes
        update_option('woocommerce_thumbnail_image_width', $thumbnail_width);
        update_option('woocommerce_single_image_width', $main_image_width);

        update_option('woocommerce_thumbnail_cropping', 'custom');
        update_option('woocommerce_thumbnail_cropping_custom_width', $cropping_custom_width);
        update_option('woocommerce_thumbnail_cropping_custom_height', $cropping_custom_height);
    }
    add_action( 'after_setup_theme', 'themename_woocommerce_setup_size_image' );
}

if(themename_tbay_get_global_config('config_media',false)) {
    remove_action( 'after_setup_theme', 'themename_woocommerce_setup_size_image' );
}