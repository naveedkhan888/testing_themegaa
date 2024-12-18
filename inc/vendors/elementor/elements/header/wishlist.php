<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Wishlist')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Wishlist extends Themename_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'xptheme-wishlist';
    }

    public function get_title()
    {
        return esc_html__('Themename Wishlist', 'themename');
    }

    public function get_icon()
    {
        return 'eicon-heart';
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Wishlist', 'themename'),
            ]
        );

        $this->add_control(
            'icon_wishlist',
            [
                'label'              => esc_html__('Icon', 'themename'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'xp-icon xp-icon-favorite',
                    'library' => 'xptheme-custom',
                ],
            ]
        );
        
        $this->add_control(
            'icon_wishlist_size',
            [
                'label' => esc_html__('Font Size Icon', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'show_title_wishlist',
            [
                'label'              => esc_html__('Display Title', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'title_wishlist',
            [
                'label'              => esc_html__('Title', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('My Wishlist', 'themename'),
                'condition' => [
                    'show_title_wishlist' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'show_total_wishlist',
            [
                'label'              => esc_html__('Show Total', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
            ]
        );
    
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
        $this->register_section_style_total();
    }

    private function register_section_style_icon()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist i'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist > a'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist a:hover i'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist a:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    private function register_section_style_text()
    {
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title_wishlist' => 'yes'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_header_typography',
                'selector' => '{{WRAPPER}} .title-wishlist',
            ]
        );


        $this->start_controls_tabs('tabs_style_text');

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        $this->add_control(
            'color_text',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-wishlist'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        $this->add_control(
            'hover_color_text',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-wishlist:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    private function register_section_style_total()
    {
        $this->start_controls_section(
            'section_style_total',
            [
                'label' => esc_html__('Style Total', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wishlist_total_typography',
                'selector' => '{{WRAPPER}} .top-wishlist .count_wishlist',
            ]
        );

        $this->add_control(
            'color_number',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'bg_total',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist'    => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'position_top',
            [
                'label'     => esc_html__('Position Vertical', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'position_left',
            [
                'label'     => esc_html__('Position Horizontal', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -40,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                    '.rtl {{WRAPPER}} .top-wishlist .count_wishlist' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ],
            ]
        );
        

        $this->end_controls_section();
    }
    

    public function render_item_wishlist()
    {
        $this->add_render_attribute('wishlist', 'class', 'wishlist');
        $settings = $this->get_settings();
        extract($settings);
        $url_wishlist = YITH_WCWL()->get_wishlist_url();
        $count_wishlist = YITH_WCWL_Wishlists()->count_items_in_wishlist(); ?>
        <a href="<?php echo esc_url($url_wishlist)?>" <?php $this->print_render_attribute_string('wishlist'); ?>>
            <?php $this->render_item_icon($icon_wishlist); ?>
           <?php if ($show_total_wishlist === 'yes') {
            ?>
                <span class="count_wishlist"><span><?php echo trim($count_wishlist) ?></span></span>
               <?php 
        } ?>

           <?php if ($show_title_wishlist === 'yes' && !empty($title_wishlist) && isset($title_wishlist)) {
            ?>
                <span class="title-wishlist"><?php echo trim($title_wishlist) ?></span>
               <?php
        } ?>


            
            
        </a>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Wishlist());
