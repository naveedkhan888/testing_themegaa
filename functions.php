<?php
/**
 * lasa functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Lasa
 * @since Lasa 1.0
 */


require get_theme_file_path('inc/functions-global.php');

/*Start Class Main*/
require get_theme_file_path('inc/classes/class-main.php');

/*
 Include Required Plugins
*/
require get_theme_file_path('inc/functions-plugins.php');


require_once(get_parent_theme_file_path(LASA_INC . '/classes/class-tgm-plugin-activation.php'));

require_once(get_parent_theme_file_path(LASA_INC . '/functions-helper.php'));
require_once(get_parent_theme_file_path(LASA_INC . '/functions-frontend.php'));
require_once(get_parent_theme_file_path(LASA_INC . '/functions-mobile.php'));

/**Include Merlin Import Demo**/
if( apply_filters( 'lasa_active_theme_setup', true ) ) {
    require_once(get_parent_theme_file_path(LASA_MERLIN . '/vendor/autoload.php'));
    require_once(get_parent_theme_file_path(LASA_MERLIN . '/class-merlin.php'));
    require_once(get_parent_theme_file_path(LASA_INC . '/merlin-config.php'));
}

require_once( get_parent_theme_file_path( LASA_INC . '/skins/'. lasa_tbay_get_theme() .'/functions.php') );

/**
 * Customizer
 *
 */
require_once(get_parent_theme_file_path(LASA_INC . '/customizer/custom-header.php'));
require_once(get_parent_theme_file_path(LASA_INC . '/skins/'. lasa_tbay_get_theme() .'/customizer.php') );
require_once(get_parent_theme_file_path(LASA_INC . '/customizer/custom-styles.php'));
/**
 * Classess file
 *
 */

/**
 * Implement the Custom Styles feature.
 *
 */
require_once(get_parent_theme_file_path(LASA_CLASSES . '/custommenu.php'));

/**
 * Custom template tags for this theme.
 *
 */

require_once(get_parent_theme_file_path(LASA_INC . '/template-tags.php'));
require_once(get_parent_theme_file_path(LASA_INC . '/template-hooks.php'));

if( lasa_is_meta_box() ) {
    require_once(get_parent_theme_file_path(LASA_VENDORS . '/meta-box/page.php'));
    require_once(get_parent_theme_file_path(LASA_VENDORS . '/meta-box/post.php'));
    
    if( defined('TBAY_PORTFOLIOS') && TBAY_PORTFOLIOS &&  apply_filters( 'wpthembay_register_post_types_portfolio', true) ) {
        require_once(get_parent_theme_file_path(LASA_VENDORS . '/meta-box/portfolio.php')); 
    }

    require_once(get_parent_theme_file_path(LASA_VENDORS . '/meta-box/discount-campaign.php')); 
}  

if( lasa_wpml_is_activated() )  {
	require_once( get_parent_theme_file_path( LASA_VENDORS . '/compatible/wpml.php') );
}

if ( lasa_woocommerce_activated() ) {
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/wc-admin.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/skins/'. lasa_tbay_get_theme() .'.php') );
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/classes/class-wc.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/classes/class-wc-ajax.php'));
    
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/wc-template-functions.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/wc-template-hooks.php'));
 
    /**Modules**/
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/swatches.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/breadcrumb.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/quick-view.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/image-mode.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/form-login.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/recently-viewed.php'));

    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/aska-question.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/delivery-return.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/modules/size-guid.php'));

    /*compatible*/
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/wc_vendors.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/wc-dokan.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/wcfm_multivendor.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/mvx_vendor.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/wc-germanized.php'));
    require_once(get_parent_theme_file_path(LASA_WOOCOMMERCE . '/compatible/woo-variation-swatches-pro.php'));
}

if( lasa_wpthembay_core_activated() ) {
	if ( function_exists( 'mc4wp_show_form' ) ) {
		require_once( get_parent_theme_file_path( LASA_WIDGETS . '/popup_newsletter.php') );
	}
	
	require_once( get_parent_theme_file_path( LASA_WIDGETS . '/recent_post.php') ); 
	require_once( get_parent_theme_file_path( LASA_WIDGETS . '/socials.php') );

    if( lasa_elementor_activated() ) {  
        require_once( get_parent_theme_file_path( LASA_WIDGETS . '/template_elementor.php') );
    }
}


if( lasa_redux_framework_activated() ) {
    /*Redux FrameWork*/
    require_once(get_parent_theme_file_path(LASA_VENDORS . '/redux-framework/class-redux.php'));
    require_once(get_parent_theme_file_path(LASA_VENDORS . '/redux-framework/redux-config.php'));

    
    /**Reudx Settings**/
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/01-general.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/02-header.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/03-footer.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/04-mobile.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/05-style.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/06-woocommerce.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/07-blog.php') );

    if( defined('TBAY_PORTFOLIOS') && TBAY_PORTFOLIOS &&  apply_filters( 'wpthembay_register_post_types_portfolio', true) ) {
        require_once( get_parent_theme_file_path(LASA_CONFIG . '/08-portfolio.php') );
    }

    require_once( get_parent_theme_file_path(LASA_CONFIG . '/09-page-404.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/10-social-share.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/11-performance.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/12-custom-css-js.php') );
    require_once( get_parent_theme_file_path(LASA_CONFIG . '/13-import-export.php') );
}

require_once(get_parent_theme_file_path(LASA_VENDORS . '/megamenu/megamenu.php'));

if ( lasa_elementor_activated() ) {
    require_once(get_parent_theme_file_path(LASA_VENDORS . '/elementor/class-elementor.php'));

    if( lasa_elementor_pro_activated() ) {
        require_once(get_parent_theme_file_path(LASA_VENDORS . '/elementor/class-elementor-pro.php'));
    }

    require_once(get_parent_theme_file_path(LASA_VENDORS . '/elementor/icons/icons.php'));
}