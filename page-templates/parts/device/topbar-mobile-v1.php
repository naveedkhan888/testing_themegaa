<?php
    if( themename_checkout_optimized() ) return;
    $class_top_bar 	=  '';

    $always_display_logo 			= themename_tbay_get_config('always_display_logo', true);
    if (!$always_display_logo && !themename_catalog_mode_active() && themename_woocommerce_activated() && (is_product() || is_cart() || is_checkout())) {
        $class_top_bar .= ' active-home-icon';
    }
?>
<div class="topbar-device-mobile d-xl-none clearfix <?php echo esc_attr($class_top_bar); ?>">

	<?php
        /**
        * themename_before_header_mobile hook
        */
        do_action('themename_before_header_mobile');

        /**
        * Hook: themename_header_mobile_content.
        *
        * @hooked themename_the_button_mobile_menu - 5
        * @hooked themename_the_logo_mobile - 10
        * @hooked themename_the_title_page_mobile - 10
        */

        do_action('themename_header_mobile_content');

        /**
        * themename_after_header_mobile hook

        * @hooked themename_the_search_header_mobile - 5
        */
        
        do_action('themename_after_header_mobile');
    ?>
</div>