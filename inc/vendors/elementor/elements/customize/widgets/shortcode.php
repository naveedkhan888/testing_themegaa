<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace

if (! defined('ABSPATH') || function_exists('Lasa_Widget_Shortcode')) {
    exit; // Exit if accessed directly.
}
/**
 * Elementor shortcode widget.
 *
 * Elementor widget that insert any shortcodes into the page.
 *
 * @since 1.0.0
 */
class Lasa_Widget_Shortcode extends Widget_Shortcode
{

	/**
	 * Register shortcode widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_shortcode',
			[
				'label' => esc_html__( 'Shortcode', 'lasa' ),
			]
		);

		$this->add_control(
			'shortcode',
			[
				'label' => esc_html__( 'Enter your shortcode', 'lasa' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => '[gallery id="123" size="medium"]',
				'default' => '',
			]
		);

		$this->add_control(
            'only_home_page',
            [
                'label'              => esc_html__('Only Show Home Page', 'lasa'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'no',
            ]
        );

		$this->end_controls_section();
	}

    /**
	 * Render shortcode widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$shortcode = $this->get_settings_for_display( 'shortcode' );
		$only_home_page = $this->get_settings_for_display( 'only_home_page' );

		if(!lasa_tbay_is_home_page() && $only_home_page === 'yes') {
			return;
		}

		$shortcode = do_shortcode( shortcode_unautop( $shortcode ) );
		?>
		<div class="elementor-shortcode"><?php echo trim($shortcode);
	}
}
$widgets_manager->register(new Lasa_Widget_Shortcode());