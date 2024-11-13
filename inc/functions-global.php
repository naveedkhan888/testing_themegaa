<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Lasa 1.0
 */
define('LASA_THEME_VERSION', '1.0');

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define('LASA_THEME_DIR', get_template_directory_uri());
define('LASA_THEMEROOT', get_template_directory());
define('LASA_IMAGES', LASA_THEME_DIR . '/images');
define('LASA_SCRIPTS', LASA_THEME_DIR . '/js');

define('LASA_STYLES', LASA_THEME_DIR . '/css');

define('LASA_INC', 'inc');
define('LASA_MERLIN', LASA_INC . '/merlin');
define('LASA_CLASSES', LASA_INC . '/classes');
define('LASA_VENDORS', LASA_INC . '/vendors');
define('LASA_CONFIG', LASA_VENDORS . '/redux-framework/config');
define('LASA_WOOCOMMERCE', LASA_VENDORS . '/woocommerce');
define('LASA_ELEMENTOR', LASA_THEMEROOT . '/inc/vendors/elementor');
define('LASA_ELEMENTOR_TEMPLATES', LASA_THEMEROOT . '/elementor_templates');
define('LASA_PAGE_TEMPLATES', LASA_THEMEROOT . '/page-templates');
define('LASA_WIDGETS', LASA_INC . '/widgets');

define('LASA_ASSETS', LASA_THEME_DIR . '/inc/assets');
define('LASA_ASSETS_IMAGES', LASA_ASSETS    . '/images');

define('LASA_MIN_JS', '');

define('TBAY_DISCOUNT_CAMPAIGN', true);
define('TBAY_PORTFOLIOS', true);

if (! isset($content_width)) {
    $content_width = 660;
}

function lasa_tbay_get_config($name, $default = '')
{
    global $lasa_options;
    if (isset($lasa_options[$name])) {
        return $lasa_options[$name];
    }
    return $default;
}

function lasa_tbay_get_global_config($name, $default = '')
{
    $options = get_option('lasa_tbay_theme_options', array());
    if (isset($options[$name])) {
        return $options[$name];
    }
    return $default;
}
