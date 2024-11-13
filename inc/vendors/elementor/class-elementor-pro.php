<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('lasa_elementor_pro_before_do_header')) {
    add_action('elementor/theme/before_do_header', 'lasa_elementor_pro_before_do_header');
    function lasa_elementor_pro_before_do_header()
    {
        $class = (lasa_tbay_get_config('hidden_header_el_pro_mobile', true)) ? 'hidden-header' : '';

        echo '<div class="tbay-el-pro-wrapper wrapper-container '. esc_attr($class) .'"><div id="tbay-main-content" class="site">';
    }
}

if (!function_exists('lasa_elementor_pro_after_do_header')) {
    add_action('elementor/theme/after_do_header', 'lasa_elementor_pro_after_do_header');
    function lasa_elementor_pro_after_do_header()
    {
        do_action('lasa_before_theme_header');

        echo '<div class="site-content-contain"><div id="content" class="site-content">';
    }
}


if (!function_exists('lasa_elementor_pro_before_do_footer')) {
    add_action('elementor/theme/before_do_footer', 'lasa_elementor_pro_before_do_footer');
    function lasa_elementor_pro_before_do_footer()
    {
        echo '</div></div>';
    }
}


if (!function_exists('lasa_elementor_pro_after_do_footer')) {
    add_action('elementor/theme/after_do_footer', 'lasa_elementor_pro_after_do_footer');
    function lasa_elementor_pro_after_do_footer()
    {
        echo '</div>' . do_action('lasa_end_wrapper') . '</div>';
    }
}