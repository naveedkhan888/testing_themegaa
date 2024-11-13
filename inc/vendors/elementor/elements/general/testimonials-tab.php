<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Testimonials_Tab')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Testimonials_Tab extends Themename_Elementor_Widget_Base
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
        return 'tbay-testimonials-tab';
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
        return esc_html__('Themename Testimonials Tab', 'themename');
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
        return 'eicon-tabs';
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
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $repeater = $this->register_tab_repeater();

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tab Items', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_tabs_default(),
            ]
        );

        $this->add_control(
            'testimonials_icon',
            [
                'label' => esc_html__('Choose Icon', 'themename'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-quote-2',
                    'library' => 'tbay-custom',
                ],
            ]
        );


        $this->end_controls_section();

        $this->style_testimonials_tab_title_section();
        $this->style_testimonials_tab_content_section();
        $this->style_testimonials_tab_icon_section();
    }

    private function register_tab_repeater()
    {
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'tab_name',
            [
                'label' => esc_html__('Tab Title', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Content', 'themename'),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

        return $repeater;
    }

    private function register_set_tabs_default()
    {
        $defaults = [
            [
                'tab_name' => esc_html__('Tab name 1', 'themename'),
                'tab_content' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'themename'),
            ],
            [
                'tab_name' => esc_html__('Tab name 2', 'themename'),
                'tab_content' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque 2', 'themename'),
            ],
            [
                'tab_name' => esc_html__('Tab name 3', 'themename'),
                'tab_content' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque 3', 'themename'),
            ],
        ];

        return $defaults;
    }

    private function style_testimonials_tab_title_section()
    {
        $this->start_controls_section(
            'section_style_testimonials_tab_title',
            [
                'label' => esc_html__('Testimonials Tab Title', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'testimonials_tab_title_align',
            [
                'label' => esc_html__('Align', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-title' => 'justify-content: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_tab_title_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .nav-testimonials-title .name',
            ]
        ); 

        $this->start_controls_tabs('testimonials_tab_title_tabs');

        $this->start_controls_tab(
            'testimonials_tab_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'testimonials_tab_title_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link:not(.active) .name' => 'color: {{VALUE}};',
                ],
            ]
        );
        
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'testimonials_tab_title_bg',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .nav-testimonials-title .nav-link',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);


        $this->end_controls_tab();

        $this->start_controls_tab(
            'testimonials_tab_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'testimonials_tab_title_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link.active .name,
                    {{WRAPPER}} .nav-testimonials-title .nav-link:hover .name' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .nav-testimonials-title .nav-link.active::before, 
                    {{WRAPPER}} .nav-testimonials-title .nav-link:hover::before' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'testimonials_tab_title_bg_hover',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .nav-testimonials-title .nav-link.active,{{WRAPPER}} .nav-testimonials-title .nav-link:hover',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'testimonials_tab_title_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'testimonials_tab_title_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonials_tab_title_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'testimonials_under_title_bg',
            [
                'label' => esc_html__('Background under title', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-title .nav-link:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function style_testimonials_tab_content_section()
    {
        $this->start_controls_section(
            'section_style_testimonials_tab_content',
            [
                'label' => esc_html__('Testimonials Content', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'testimonials_tab_content_align',
            [
                'label' => esc_html__('Align', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ], 
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-content .tab-pane' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_tab_content_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .nav-testimonials-content .content',
            ]
        ); 

        $this->start_controls_tabs('testimonials_tab_content_tabs');

        $this->start_controls_tab(
            'testimonials_tab_content_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'testimonials_tab_content_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-content .content' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'testimonials_tab_content_bg',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .nav-testimonials-content .tab-pane',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'testimonials_tab_content_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'testimonials_tab_content_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-content .tab-pane:hover .content' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'testimonials_tab_content_bg_hover',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .nav-testimonials-content .tab-pane:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'testimonials_tab_content_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nav-testimonials-content .tab-pane' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'testimonials_tab_content_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-testimonials-content .tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonials_tab_content_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-testimonials-content .tab-pane' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function style_testimonials_tab_icon_section() {
    $this->start_controls_section(
        'section_style_testimonials_tab_icon',
        [
            'label' => esc_html__('Testimonials Icon', 'themename'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );


    $this->add_responsive_control(
        'testimonials_tab_icon_size',
        [
            'label' => esc_html__('Font Size', 'themename'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 8,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .testimonial-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


    $this->start_controls_tabs('testimonials_tab_icon_tabs');

    $this->start_controls_tab(
        'testimonials_tab_icon_tab_normal',
        [
            'label' => esc_html__('Normal', 'themename'),
        ]
    );

    $this->add_control(
        'testimonials_tab_icon_color',
        [
            'label' => esc_html__('Text Color', 'themename'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .testimonial-icon i' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'testimonials_tab_icon_tab_hover',
        [
            'label' => esc_html__('Hover', 'themename'),
        ]
    );

    $this->add_control(
        'testimonials_tab_icon_color_hover',
        [
            'label' => esc_html__('Text Color', 'themename'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .nav-testimonials-content .tab-pane:hover .testimonial-icon i' => 'color: {{VALUE}} !important;',
            ],
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();
    
    $this->add_responsive_control(
        'testimonials_tab_icon_padding',
        [
            'label'      => esc_html__('Padding', 'themename'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .testimonial-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );
    $this->add_responsive_control(
        'testimonials_tab_icon_margin',
        [
            'label'      => esc_html__('Margin', 'themename'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .testimonial-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
            ],
        ]
    );

    $this->end_controls_section();
}

    protected function render_tabs_title($tabs, $id) {
        $count = 0;
        ?>
        <div class="nav nav-tabs nav-testimonials-title" id="tab-nav-testimonials-<?php echo esc_attr( $id ); ?>" role="tablist">
            <?php foreach ($tabs as $key) : ?>
                <?php 
                    $class_active = ( $count === 0 ) ? 'active' : '';
                    $selected = ( $count === 0 ) ? 'true' : 'false';
                ?>

                <button class="nav-link <?php echo esc_attr( $class_active ); ?>" id="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" data-bs-toggle="tab" data-bs-target="#nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" type="button" role="tab" aria-controls="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" aria-selected="<?php echo esc_attr( $selected ) ?>"><span class="name"><?php echo trim($key['tab_name']); ?></span></button>

                <?php $count++; ?>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function render_tabs_content($tabs, $id) {
        $count = 0;
        $settings = $this->get_settings_for_display();
        ?>
        <div class="tab-content nav-testimonials-content" id="nav-content-testimonials-<?php echo esc_attr( $id ); ?>">
            <?php foreach ($tabs as $key) : ?>
            <?php 
                $class_active = ( $count === 0 ) ? 'show active' : '';
            ?>

            <div class="tab-pane fade <?php echo esc_attr( $class_active ); ?>" id="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" role="tabpanel" aria-labelledby="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>">
                <?php 
                    echo '<div class="content">'. trim( $key['tab_content'] ) .'</div>';
                ?>

                <?php 
                    if( !empty($settings['testimonials_icon']['value']) ) {
                        echo '<div class="testimonial-icon elementor-icon">';
                            $this->render_item_icon($settings['testimonials_icon']);
                        echo '</div>';
                    }
                ?>
            </div>

            <?php $count++; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Testimonials_Tab());