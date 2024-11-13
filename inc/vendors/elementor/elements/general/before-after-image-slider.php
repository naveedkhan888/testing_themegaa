<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Themename_Elementor_Before_After_Image_Slider') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Before_After_Image_Slider extends  Themename_Elementor_Widget_Base{
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
    public function get_name() {
        return 'tbay-before-after-image-slider';
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
    public function get_title() {
        return esc_html__( 'Themename Before After Image Slider', 'themename' );
    }

    public function get_script_depends() {
        return [ 'before-after-image' ];
    } 

    public function get_style_depends() {
        return [ 'before-after-image' ];
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
    public function get_icon() {
        return 'eicon-sync';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'themename' ),
            ]
        );

        $this->add_control(
            'image_before',
            [
                'label' => esc_html__('Image Before', 'themename'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $this->add_control(
            'image_after',
            [
                'label' => esc_html__('Image After', 'themename'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
 
        $this->end_controls_section();

        $this->register_controls_section_settings();
        $this->register_controls_style();
    }

    protected function register_controls_style()
    {

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__('Style General', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_text_typography',
                'selector' => '{{WRAPPER}} .cndkbeforeafter-item-before-text, {{WRAPPER}} .cndkbeforeafter-item-after-text',
            ]
        );

        $this->add_control(
            'style_heading_before',
            [
                'label' => esc_html__('Before Text', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'style_before_bg_color',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cndkbeforeafter-item-before-text' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'style_before_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cndkbeforeafter-item-before-text' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_before_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-before-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        
        $this->add_responsive_control(
            'style_before_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-before-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'style_before_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .cndkbeforeafter-item-before-text',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'style_before_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top' => '3',
                    'right' => '3',
                    'bottom' => '3',
                    'left' => '3',
                    'unit' => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-before-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'style_heading_after',
            [
                'label' => esc_html__('After Text', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        
        $this->add_control(
            'style_after_bg_color',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cndkbeforeafter-item-after-text' => 'background: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_control(
            'style_after_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cndkbeforeafter-item-after-text' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'style_after_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-after-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        
        $this->add_responsive_control(
            'style_after_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-after-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'style_after_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .cndkbeforeafter-item-after-text',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'style_after_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top' => '3',
                    'right' => '3',
                    'bottom' => '3',
                    'left' => '3',
                    'unit' => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .cndkbeforeafter-item-after-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_section_settings()
    {
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'themename' ),
            ]
        );

        $this->add_control(
            'settings_mode',
            [
                'label'     => esc_html__('Mode', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'drag',
                'options'   => [
                    'hover'      => 'Hover',
                    'drag'  => 'Drag',
                ],
            ]
        );

        $this->add_control(
            'settings_showText',
            [
                'label' => esc_html__('Show Text', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'heading_before',
            [
                'label' => esc_html__('Before', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
                'condition' => [
                    'settings_showText' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'settings_beforeText',
            [
                'label'       => esc_html__('Before Text', 'themename'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('BEFORE', 'themename'),
                'condition' => [
                    'settings_showText' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'settings_beforeTextPosition',
            [
                'label'     => esc_html__('Before Text Position', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center-left',
                'condition' => [
                    'settings_showText' => 'yes'
                ],
                'options'   => [
                    'top-left'      => 'Top Left',
                    'top-right'      => 'Top Right',
                    'center-left'      => 'Center Left',
                    'center-right'      => 'Center Right',
                    'bottom-left'      => 'Bottom Left',
                    'bottom-right'      => 'Bottom Right',
                ],
            ]
        );

        $this->add_control(
            'heading_after',
            [
                'label' => esc_html__('After', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
                'condition' => [
                    'settings_showText' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'settings_afterText',
            [
                'label'       => esc_html__('After Text', 'themename'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('AFTER', 'themename'),
                'condition' => [
                    'settings_showText' => 'yes'
                ],
            ]
        );

        
        $this->add_control(
            'settings_afterTextPosition',
            [
                'label'     => esc_html__('After Text Position', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center-right',
                'condition' => [
                    'settings_showText' => 'yes'
                ],
                'options'   => [
                    'top-left'      => 'Top Left',
                    'top-right'      => 'Top Right',
                    'center-left'      => 'Center Left',
                    'center-right'      => 'Center Right',
                    'bottom-left'      => 'Bottom Left',
                    'bottom-right'      => 'Bottom Right',
                ],
            ]
        );

        $this->add_responsive_control(
            'settings_seperatorWidth',
            [
                'label' => esc_html__('Seperator Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
					'size' => 4,
				],
                'separator'    => 'before',
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
			'settings_seperatorOpacity',
			[
				'label' => esc_html__( 'Seperator Opacity', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => .8,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.01,
					],
				],
			]
		);

        $this->add_control(
            'settings_theme',
            [
                'label'     => esc_html__('Theme', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'light',
                'options'   => [
                    'dark'      => 'Dark',
                    'light'      => 'Light',
                ],
            ]
        );

        
        $this->add_control(
            'settings_autoSliding',
            [
                'label' => esc_html__('Auto Sliding', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );
        
        $this->add_control(
            'settings_autoSlidingStopOnHover',
            [
                'label' => esc_html__('Auto Sliding Stop On Hover', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        
        $this->add_control(
            'settings_hoverEffect',
            [
                'label' => esc_html__('Hover Effect', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        
        $this->add_control(
            'settings_enterAnimation',
            [
                'label' => esc_html__('Enter Animation', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render_item_content() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if ( !empty($image_before['url']) && !empty($image_after['url']) ) {
            ?>
            <div class="themename-before-after-wrapper">
                <div class="beforeafterdefault tbay-before-after-image-slider">
                    <div data-type="data-type-image">
                        <div data-type="before"><?php echo wp_get_attachment_image($image_before['id'], 'full'); ?></div>
                        <div data-type="after"><?php echo wp_get_attachment_image($image_after['id'], 'full'); ?></div>
                    </div>
                </div>
            </div>
            <?php
        }
        
    }
}
$widgets_manager->register(new Themename_Elementor_Before_After_Image_Slider());
