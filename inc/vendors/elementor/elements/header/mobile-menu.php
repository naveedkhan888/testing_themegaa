<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Mobile_Menu')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Mobile_Menu extends Themename_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-mobile-menu';
    }

    public function get_title()
    {
        return esc_html__('Themename Mobile Menu', 'themename');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    public function on_export($element)
    {
        unset($element['settings']['menu']);

        return $element;
    }

    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $this->add_control(
            'theme_options_screen',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(__('<strong>You need to select Main Menu Mobile on your site.</strong><br>Go to the <a href="%s" target="_blank">Theme Options Screen</a>', 'themename'), admin_url('admin.php?page=themename_options')),
                'separator'       => 'after',
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
            ]
        );

        $this->add_control(
            'general_title_heading',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'general_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'general_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'themename'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'condition' => [
                    'general_title!' => ''
                ],
                'label_block' => true,
                'default' => 'h3',
            ]
        );

        
        $this->add_control(
            'general_icon_heading',
            [
                'label' => esc_html__('Icon', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'general_icon',
            [
                'label' => esc_html__('Icon', 'themename'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'tb-icon tb-icon-bars',
                    'library' => 'tbay-custom',
                ],
            ]
        );

        $this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'themename' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'themename' ),
					'right' => esc_html__( 'After', 'themename' ),
				],
                'condition' => [
                    'general_icon[value]!' => ''
                ],
			]
		);

        $this->end_controls_section();
        $this->register_section_style_menu();
    }

    private function register_section_style_menu()
    {

        $this->start_controls_section(
            'section_style_mobile_menu',
            [
                'label' => esc_html__('Mobile Menu', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_style_heading',
            [
                'label' => esc_html__('Title Style', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'menu_title_typography',
                'selector'  => '{{WRAPPER}} .mobile-menu-title',
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('tabs_style_title');

        $this->start_controls_tab(
            'tab_style_title_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-title'  => 'color: {{VALUE}} !important',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_style_title_hover',
            [
                'label' => esc_html__('Hover Active', 'themename'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-elementor-menu-mobile:hover .mobile-menu-title'  => 'color: {{VALUE}} !important' ,
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
            'style_title_margin',
            [
                'label'     => esc_html__('Margin', 'themename'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-title'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ], 
            ]
        );

        $this->add_responsive_control(
            'style_title_padding',
            [
                'label'     => esc_html__('Padding', 'themename'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-title'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ], 
            ]
        );

        $this->add_control(
            'general_icon_style_heading',
            [
                'label' => esc_html__('Icon Style', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_style_icon_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-icon'  => 'color: {{VALUE}} !important',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_style_icon_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Text Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-elementor-menu-mobile:hover .mobile-menu-icon'  => 'color: {{VALUE}} !important' ,
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_control(
            'style_icon_size',
            [
                'label'     => esc_html__('Font Size Icon', 'themename'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-icon'  => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ], 
            ]
        );

        
        $this->add_responsive_control(
            'style_icon_margin',
            [
                'label'     => esc_html__('Margin', 'themename'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-icon'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ], 
            ]
        );

        $this->add_responsive_control(
            'style_icon_padding',
            [
                'label'     => esc_html__('Padding', 'themename'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mobile-menu-icon'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ], 
            ]
        );

        $this->end_controls_section();
    }
}
$widgets_manager->register(new Themename_Elementor_Mobile_Menu());
