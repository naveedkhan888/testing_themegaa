<?php

defined( 'ABSPATH' ) || exit();


class Lasa_Megamenu {

	private $menu_items  = [];

	public function __construct() {
		$this->includes_core();
		$this->includes();

		if( lasa_elementor_activated() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		add_filter( 'lasa_nav_menu_args', [ $this, 'set_menu_args' ], 99999 );
	}

	public function set_menu_args( $args ) {
		$args['walker'] = new Lasa_Megamenu_Walker();

		return $args;
	}

	public function enqueue_scripts() {
		foreach ( $this->menu_items as $id ) {
			Elementor\Core\Files\CSS\Post::create()->enqueue();
		}
	}

	private function includes_core(){
		if ( is_admin() ) {
			include_once get_template_directory() . '/inc/vendors/megamenu/includes/admin/class-admin.php';
		}
		include_once get_template_directory() . '/inc/vendors/megamenu/includes/core-functions.php';
	}

	private function includes() { 
		include_once get_template_directory() . '/inc/vendors/megamenu/includes/hook-functions.php';
		include_once get_template_directory() . '/inc/vendors/megamenu/includes/class-menu-walker.php';
	}
}

return new Lasa_Megamenu();
