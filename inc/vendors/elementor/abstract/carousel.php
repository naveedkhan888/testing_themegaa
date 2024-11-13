<?php
if (!defined('ABSPATH') || function_exists('Lasa_Elementor_Carousel_Base')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

abstract class Lasa_Elementor_Carousel_Base extends Lasa_Elementor_Responsive_Base
{
    public function get_name()
    {
        return 'tbay-carousel';
    }

    private function get_rows()
    {
        $value = apply_filters('lasa_admin_elementor_rows', [
            1 => 1,
            2 => 2,
            3 => 3
        ]);

        return $value;
    }

    protected function add_control_carousel($condition = array())
    {
        $this->register_section_carousel_options($condition);
        $this->register_section_style_navigation($condition);
        $this->register_section_style_pagination($condition);
    }

    private function register_section_carousel_options($condition = array())
    {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => esc_html__('Carousel Options', 'lasa'),
                'type'  => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );
 

        $this->add_control(
            'rows',
            [
                'label' => esc_html__('Rows', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default' => 1,
                'options' => $this->get_rows()
            ]
        );

        $this->add_control(
            'carousel_blur',
            [
                'label'     => esc_html__('Show carousel Blur?', 'lasa'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        ); 

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'description' => esc_html__('Slide/Fade animation speed', 'lasa'),
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => esc_html__('Navigation', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('Show/hidden Navigation', 'lasa'),
            ]
        );

        $this->add_responsive_control(
            'navigation_prev',
            [
                'label' => esc_html__('Navigation Prev', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 
                        'min' => -300,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel > .slick-arrow.slick-prev' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                    '.rtl {{WRAPPER}} .owl-carousel > .slick-arrow.slick-prev' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ],
                'condition' => [
                    'navigation' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'navigation_next',
            [
                'label' => esc_html__('Navigation Next ', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 
                        'min' => -300,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel > .slick-arrow.slick-next' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                    '.rtl {{WRAPPER}} .owl-carousel > .slick-arrow.slick-next' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ],
                'condition' => [
                    'navigation' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'description' => esc_html__('Show/hidden Pagination', 'lasa'),
            ]
        );


        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Infinite Loop', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => [
                    'carousel_blur!' => 'yes'
                ],
                'description' => esc_html__('Show/hidden Infinite Loop', 'lasa'),
            ]
        );

        $this->add_control(
            'auto',
            [
                'label' => esc_html__('Autoplay', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__('Show/hidden Autoplay', 'lasa'),
            ]
        );

        $this->add_control(
            'autospeed',
            [
                'label' => esc_html__('Autoplay Speed', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1000,
                'condition' => [
                    'auto' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'disable_mobile',
            [
                'label' => esc_html__('Disable Carousel On Mobile', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__('To help load faster in mmobile', 'lasa'),
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_style_navigation($condition = array())
    {
        $condition['navigation'] = 'yes';

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => esc_html__('Navigation', 'lasa'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'arrows_width',
            [
                'label' => esc_html__('Width', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'navigation' => [ 'yes' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_height',
            [
                'label' => esc_html__('Height', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'yes' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size_icon',
            [
                'label' => esc_html__('Size Icon', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'yes' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size_position',
            [
                'label' => esc_html__('Position', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow.slick-prev' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow.slick-next' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'yes' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_radius',
            [
                'label' => esc_html__('Border Radius', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_text_color',
            [
                'label' => esc_html__('Text Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_text_color_hover',
            [
                'label' => esc_html__('Text Color Hover', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-arrow:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    private function register_section_style_pagination($condition = array())
    {
        $condition['pagination'] = 'yes';

        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => esc_html__('Pagination', 'lasa'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'pagination_width',
            [
                'label' => esc_html__('Width', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-dots li button' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_height',
            [
                'label' => esc_html__('Height', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_position',
            [
                'label' => esc_html__('Position', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_radius',
            [
                'label' => esc_html__('Border Radius', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element .owl-carousel .slick-dots li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    
}
