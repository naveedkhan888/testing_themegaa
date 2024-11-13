<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Custom_Language')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Lasa_Elementor_Custom_Language extends Lasa_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-custom-language';
    }

    public function get_title()
    {
        return esc_html__('Lasa Language', 'lasa');
    }

    public function get_icon()
    {
        return 'eicon-text-area';
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }
       
    protected function lasa_custom_language()
    {
        do_action('lasa_tbay_header_custom_language');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('General', 'lasa'),
            ]
        );

        $this->add_control(
            'position_sub_menu',
            [
                'label'     => esc_html__('Position Sub Menu', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    'top' => esc_html__('Top', 'lasa'),
                    'bottom' => esc_html__('Bottom', 'lasa'),
                ],
                'default' => 'top',
                'prefix_class' => 'sub-menu-',
                
            ]
        );
    
        $this->end_controls_section();
        $this->style_language_section();
    }
    protected function style_language_section() {
        $this->start_controls_section(
            'section_style_custom_language',
            [
                'label' => esc_html__('Style Language', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_language_typography',
                'selector' => '{{WRAPPER}} .tbay-custom-language a span',
            ]
        );

        $this->start_controls_tabs('custom_language_tabs');

        $this->start_controls_tab(
            'custom_language_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'custom_language_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-custom-language .select-button span.native,
                    {{WRAPPER}} .tbay-custom-language .select-button:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'custom_language_bg',
            [
                'label' => esc_html__('Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-custom-language .list-item-wrapper' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_language_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'custom_language_color_hover',
            [
                'label' => esc_html__('Hover Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '', 
                'selectors' => [
                    '{{WRAPPER}} .tbay-custom-language .select-button:hover span.native,{{WRAPPER}} .tbay-custom-language li:hover .select-button span.native,
                    {{WRAPPER}} .tbay-custom-language .select-button:hover:after,{{WRAPPER}} .tbay-custom-language li:hover .select-button:after,
                    {{WRAPPER}} a:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'custom_language_bg_hover',
            [
                'label' => esc_html__('Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-custom-language .list-item-wrapper:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'custom_language_padding',
            [
                'label'     => esc_html__('Padding', 'lasa'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper'        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_language_margin',
            [
                'label'     => esc_html__('Margin', 'lasa'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper'        => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
$widgets_manager->register(new Lasa_Elementor_Custom_Language());
