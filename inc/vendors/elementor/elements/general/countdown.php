<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Countdown')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Countdown extends Themename_Elementor_Widget_Base
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
        return 'tbay-countdown';
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
        return 'Themename Countdown';
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
        return 'eicon-countdown';
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
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Due Date', 'themename'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => gmdate( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				/* translators: %s: Time zone. */
                'dynamic' => [
					'active' => true,
				],
                'description' => sprintf( esc_html__( 'Date set according to your timezone: %s.', 'themename' ), Elementor\Utils::get_timezone_string() ),
                'label_block' => true,
            ]
        );

		$this->add_control(
			'show_days',
			[
				'label' => esc_html__( 'Days', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label' => esc_html__( 'Hours', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label' => esc_html__( 'Minutes', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[
				'label' => esc_html__( 'Seconds', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_separator',
			[
				'label' => esc_html__( 'Show Separator', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => '',
				'prefix_class' => 'show-separator-',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_separator',
			[
				'label' => esc_html__( 'Separator', 'themename' ),
				'type' => Controls_Manager::TEXT,
				'default' => ':',
				'condition' => [
					'show_separator' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		
		$this->add_control(
			'show_labels',
			[
				'label' => esc_html__( 'Show Label', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themename' ),
				'label_off' => esc_html__( 'Hide', 'themename' ),
				'default' => 'yes',
				'prefix_class' => 'show-labels-',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label' => esc_html__( 'Custom Label', 'themename' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_days',
			[
				'label' => esc_html__( 'Days', 'themename' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Days', 'themename' ),
				'placeholder' => esc_html__( 'Days', 'themename' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_days' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label' => esc_html__( 'Hours', 'themename' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hours', 'themename' ),
				'placeholder' => esc_html__( 'Hours', 'themename' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_hours' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label' => esc_html__( 'Minutes', 'themename' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Minutes', 'themename' ),
				'placeholder' => esc_html__( 'Minutes', 'themename' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_minutes' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label' => esc_html__( 'Seconds', 'themename' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Seconds', 'themename' ),
				'placeholder' => esc_html__( 'Seconds', 'themename' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_seconds' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

       
       
        $this->end_controls_section();

        $this->register_controls_style_box();
        $this->register_controls_content_style();
    }

    protected function register_controls_style_box()
    {
        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__('Boxes', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


		$this->add_responsive_control(
            'box_style_align',
            [
                'label' => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ], 
                'selectors' => [
                    '{{WRAPPER}} .tbay-countdown' => 'text-align: {{VALUE}}',
                ],
            ]
        ); 

		$this->add_responsive_control(
			'container_width',
			[
				'label' => esc_html__( 'Container Width', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tbay-countdown' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'box_tabs_background' );

		$this->start_controls_tab(
			'box_tab_background_normal',
			[
				'label' => esc_html__( 'Normal', 'themename' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_background_color',
				'selector' => '{{WRAPPER}} .times > div',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_tab_background_hover',
			[
				'label' => esc_html__( 'Hover', 'themename' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_background_color_hover',
				'selector' => '{{WRAPPER}}:hover .times > div',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .times > div',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'themename' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .times > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_spacing',
			[
				'label' => esc_html__( 'Space Between', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .times > div:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .times > div:not(:last-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .times > div:not(:first-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .times > div:not(:last-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'themename' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .times > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

	protected function register_controls_content_style()
    {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__('Content', 'themename'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_digits',
			[
				'label' => esc_html__( 'Digits', 'themename' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->start_controls_tabs( 'digits_tabs' );

		$this->start_controls_tab(
			'digits_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'themename' ),
			]
		);


		$this->add_control(
			'digits_color',
			[
				'label' => esc_html__( 'Color', 'themename' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .times > div span:not(.label)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'digits_background_color',
				'selector' => '{{WRAPPER}} .times > div span:not(.label)',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'digits_tab_background_hover',
			[
				'label' => esc_html__( 'Hover', 'themename' ),
			]
		);

		$this->add_control(
			'digits_color_hover',
			[
				'label' => esc_html__( 'Color', 'themename' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .times >div:hover span:not(.label)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'digits_background_color_hover',
				'selector' => '{{WRAPPER}}:hover .times > div span:not(.label)',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'digits_typography',
				'separator'    => 'before',
				'selector' => '{{WRAPPER}} .times > div span:not(.label)',
			]
		);

		$this->add_responsive_control(
			'digits_padding',
			[
				'label' => esc_html__( 'Padding', 'themename' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .times > div span:not(.label)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_label',
			[
				'label' => esc_html__( 'Label', 'themename' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'label_tabs' );

		$this->start_controls_tab(
			'label_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'themename' ),
			]
		);


		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Color', 'themename' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .times span.label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'label_background_color',
				'selector' => '{{WRAPPER}} .times span.label',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'label_tab_background_hover',
			[
				'label' => esc_html__( 'Hover', 'themename' ),
			]
		);

		$this->add_control(
			'label_color_hover',
			[
				'label' => esc_html__( 'Color', 'themename' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .times >div:hover span.label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'label_background_color_hover',
				'selector' => '{{WRAPPER}} .times >div:hover span.label',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'separator'    => 'before',
				'selector' => '{{WRAPPER}} .times span.label',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'label_text_stroke',
				'selector' => '{{WRAPPER}} .times span.label',
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => esc_html__( 'Padding', 'themename' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .times span.label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_item_content() {

	}
}
$widgets_manager->register(new Themename_Elementor_Countdown());