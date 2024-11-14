<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Themename 1.0
 */
define('THEMENAME_THEME_VERSION', '1.0');

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define('THEMENAME_THEME_DIR', get_template_directory_uri());
define('THEMENAME_THEMEROOT', get_template_directory());
define('THEMENAME_IMAGES', THEMENAME_THEME_DIR . '/images');
define('THEMENAME_SCRIPTS', THEMENAME_THEME_DIR . '/js');

define('THEMENAME_STYLES', THEMENAME_THEME_DIR . '/css');

define('THEMENAME_INC', 'inc');
define('THEMENAME_MERLIN', THEMENAME_INC . '/merlin');
define('THEMENAME_CLASSES', THEMENAME_INC . '/classes');
define('THEMENAME_VENDORS', THEMENAME_INC . '/vendors');
define('THEMENAME_CONFIG', THEMENAME_VENDORS . '/redux-framework/config');
define('THEMENAME_WOOCOMMERCE', THEMENAME_VENDORS . '/woocommerce');
define('THEMENAME_ELEMENTOR', THEMENAME_THEMEROOT . '/inc/vendors/elementor');
define('THEMENAME_ELEMENTOR_TEMPLATES', THEMENAME_THEMEROOT . '/elementor_templates');
define('THEMENAME_PAGE_TEMPLATES', THEMENAME_THEMEROOT . '/page-templates');
define('THEMENAME_WIDGETS', THEMENAME_INC . '/widgets');

define('THEMENAME_ASSETS', THEMENAME_THEME_DIR . '/inc/assets');
define('THEMENAME_ASSETS_IMAGES', THEMENAME_ASSETS    . '/images');

define('THEMENAME_MIN_JS', '');

define('XPTHEME_DISCOUNT_CAMPAIGN', true);
define('XPTHEME_PORTFOLIOS', true);

if (! isset($content_width)) {
    $content_width = 660;
}

function themename_xptheme_get_config($name, $default = '')
{
    global $themename_options;
    if (isset($themename_options[$name])) {
        return $themename_options[$name];
    }
    return $default;
}

function themename_xptheme_get_global_config($name, $default = '')
{
    $options = get_option('themename_xptheme_theme_options', array());
    if (isset($options[$name])) {
        return $options[$name];
    }
    return $default;
}
