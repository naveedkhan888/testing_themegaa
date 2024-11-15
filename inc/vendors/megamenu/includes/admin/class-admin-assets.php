<?php

defined( 'ABSPATH' ) || exit();

/**
 * Themename_Megamenu_Walker
 *
 * extends Walker_Nav_Menu
 */
class Themename_Admin_Megamenu_Assets {

	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( __CLASS__, 'add_scripts_editor' ) );
	}

	public static function add_scripts_editor() {
		if ( isset( $_REQUEST['themename-menu-editable'] ) && $_REQUEST['themename-menu-editable'] ) {
			wp_register_script( 'themename-elementor-menu', get_template_directory_uri() . '/inc/vendors/megamenu/assets/js/editor.js', [], THEMENAME_THEME_VERSION );
			wp_enqueue_script( 'themename-elementor-menu' );
		}
	}

	/**
	 * enqueue scripts
	 */
	public static function enqueue_scripts( $page ) {
		if ( $page === 'nav-menus.php' ) {
			wp_enqueue_script( 'backbone' );
			wp_enqueue_script( 'underscore' );

			$suffix = '.min';
			wp_register_script(
				'jquery-elementor-select2',
				ELEMENTOR_ASSETS_URL . 'lib/e-select2/js/e-select2.full' . $suffix . '.js',
				[
					'jquery',
				],
				'4.0.6-rc.1',
				true
			);
			wp_enqueue_script( 'jquery-elementor-select2' );
			wp_register_style(
				'elementor-select2',
				ELEMENTOR_ASSETS_URL . 'lib/e-select2/css/e-select2' . $suffix . '.css',
				[],
				'4.0.6-rc.1'
			);
			wp_enqueue_style( 'elementor-select2' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_register_script( 'themename-megamenu', get_template_directory_uri() . '/inc/vendors/megamenu/assets/js/admin.js', array(
				'jquery',
				'backbone',
				'underscore'
			), THEMENAME_THEME_VERSION, true );
			wp_localize_script( 'themename-megamenu', 'themename_memgamnu_params', apply_filters( 'themename_admin_megamenu_localize_scripts', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => array(
					'close' => esc_html__( 'Close', 'themename' ),
					'submit' => esc_html__( 'Save', 'themename' )
				),
				'nonces'  => array(
					'load_menu_data' => wp_create_nonce( 'themename-menu-data-nonce' )
				)
			) ) );
			wp_enqueue_script( 'themename-megamenu' );

			wp_enqueue_style( 'themename-megamenu', get_template_directory_uri() . '/inc/vendors/megamenu/assets/css/admin.css', array(), THEMENAME_THEME_VERSION );
			wp_enqueue_style('themename-font-xptheme-custom', THEMENAME_STYLES . '/font-xptheme-custom.css', array(), THEMENAME_THEME_VERSION);
		}

	}

}

Themename_Admin_Megamenu_Assets::init();
