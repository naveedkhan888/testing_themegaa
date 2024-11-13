<?php

if (!function_exists('themename_before_render_sticky_header')) {
    function themename_before_render_sticky_header($element)
    {

        if( $element->get_data( 'isInner' ) ) return;

        if (function_exists('is_product')) {
            $menu_bar   =  apply_filters('themename_woo_product_menu_bar', 10, 2);

            if (is_product() &&  $menu_bar) {
                return;
            }
        }
 
        $settings = $element->get_settings_for_display();
 
        if (!isset($settings['enable_sticky_headers'])) {
            return;
        }

        if ($settings['enable_sticky_headers'] === 'yes') {
            $element->add_render_attribute('_wrapper', 'class', 'element-sticky-header');
        }
    }

    add_action('elementor/frontend/section/before_render', 'themename_before_render_sticky_header', 10, 2);
    add_action('elementor/frontend/container/before_render', 'themename_before_render_sticky_header', 10, 2);
}
