<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Menu_Vertical')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Lasa_Elementor_Menu_Vertical extends Lasa_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-menu-vertical';
    }

    public function get_title()
    {
        return esc_html__('Lasa Menu Vertical', 'lasa');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function on_export($element)
    {
        unset($element['settings']['menu']);

        return $element;
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('General', 'lasa'),
            ]
        );
      
        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'menu',
                [
                    'label'        => esc_html__('Menu', 'lasa'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => esc_html__('Note does not apply to Mega Menu.', 'lasa'),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'lasa'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->end_controls_section();
        $this->style_menu_vertical();
    }
    protected function style_menu_vertical()
    {
        $this->start_controls_section(
            'section_style_menu_vertical',
            [
                'label' => esc_html__('Style Menu Vertical', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('List Style Type', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'circle'      => 'Circle',
                    'decimal'      => 'Decimal',
                    'disc'  => 'Disc',
                    'disclosure-closed'  => 'Disclosure Closed',
                    'disclosure-open'  => 'Disclosure Open',
                    'square'  => 'Square',
                    'auto'  => 'Auto',
                    'none'  => 'None',
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical-container > .menu-vertical'  => 'list-style-type: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_vertical_align',
            [
                'label' => esc_html__('Align', 'lasa'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lasa'),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lasa'),
                        'icon' => 'fa fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lasa'),
                        'icon' => 'fa fa-align-right'
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical > li' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_vertical_typography',
                'selector' => '{{WRAPPER}} .menu-vertical > li > a',
            ]
        );

        $this->add_responsive_control(
            'padding_menu_vertical',
            [
                'label'     => esc_html__('Padding', 'lasa'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical > li'        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_menu_vertical',
            [
                'label'     => esc_html__('Margin', 'lasa'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical > li'        => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('menu_vertical_tabs');

        $this->start_controls_tab(
            'menu_vertical_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'menu_vertical_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical > li > a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_vertical_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'menu_vertical_color_hover',
            [
                'label' => esc_html__('Hover Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '', 
                'selectors' => [
                    '{{WRAPPER}} .menu-vertical > li.active > a' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .menu-vertical > li > a:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}
$widgets_manager->register(new Lasa_Elementor_Menu_Vertical());
