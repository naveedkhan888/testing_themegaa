<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Shortcode_Carousel')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Lasa_Elementor_Shortcode_Carousel extends Lasa_Elementor_Carousel_Base
{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tbay-shortcode-carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Lasa Shortcode Carousel', 'lasa');
    }

    public function get_script_depends()
    {
        return [ 'lasa-custom-slick', 'slick' ];
    }
 
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-shortcode';
    }

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'shortcode', 'carousel', 'code' ];
	}

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Shortcode Carousel', 'lasa'),
            ]
        );
        
        $this->add_control(
            'list_shortcode',
            [
                'label' => esc_html__('List Shortcode', 'lasa'),
                'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
                        'name' => 'shortcode',
                        'label' => esc_html__( 'Enter your shortcode', 'lasa' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'placeholder' => '[tbay_block id="block-id"]',
                        'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Thembay Shortcode</a> to manage your.', 'lasa'), admin_url('edit.php?post_type=tbay_custom_post&tbay_block_type=custom')),
                        'default' => '',
					],
                ]
            ]
        ); 

        $this->register_controls_hidden();

        $this->end_controls_section();
        $this->add_control_carousel();
    }

    protected function register_controls_hidden()
    {
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'carousel',
            ]
        );

        $this->add_control(
            'column',
            [
                'label'     => esc_html__('Columns', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );
        
        $this->add_control(
            'column_tablet',
            [
                'label'     => esc_html__('Columns Tablet ', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );

        $this->add_control(
            'column_mobile',
            [
                'label'     => esc_html__('Columns Mobile', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );

        $this->add_control(
            'col_desktop',
            [
                'label'     => esc_html__('Columns desktop', 'lasa'),
                'description' => esc_html__('Column apply when the width is between 1200px and 1600px', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );

        $this->add_control(
            'col_desktopsmall',
            [
                'label'     => esc_html__('Columns desktopsmall', 'lasa'),
                'description' => esc_html__('Column apply when the width is between 992px and 1199px', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );
 
        $this->add_control(
            'col_landscape',
            [
                'label'     => esc_html__('Columns mobile landscape', 'lasa'),
                'description' => esc_html__('Column apply when the width is between 576px and 767px', 'lasa'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 1,
            ]
        );
    }
}
$widgets_manager->register(new Lasa_Elementor_Shortcode_Carousel());
