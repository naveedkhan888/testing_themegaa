<?php
    if( lasa_checkout_optimized() ) return;
    $class_top_bar 	=  '';

    $always_display_logo 			= lasa_tbay_get_config('always_display_logo', true);
    if (!$always_display_logo && !lasa_catalog_mode_active() && lasa_woocommerce_activated() && (is_product() || is_cart() || is_checkout())) {
        $class_top_bar .= ' active-home-icon';
    }
?>
<div class="topbar-device-mobile d-xl-none clearfix <?php echo esc_attr($class_top_bar); ?>">

	<?php
        /**
        * lasa_before_header_mobile hook
        */
        do_action('lasa_before_header_mobile');

        /**
        * Hook: lasa_header_mobile_content.
        *
        * @hooked lasa_the_button_mobile_menu - 5
        * @hooked lasa_the_logo_mobile - 10
        * @hooked lasa_the_title_page_mobile - 10
        */

        do_action('lasa_header_mobile_content');

        /**
        * lasa_after_header_mobile hook

        * @hooked lasa_the_search_header_mobile - 5
        */
        
        do_action('lasa_after_header_mobile');
    ?>
</div>