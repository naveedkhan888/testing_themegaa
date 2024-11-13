<?php
if (!defined('ABSPATH') || function_exists('Themename_Elementor_Widget_Base')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;

abstract class Themename_Elementor_Widget_Base extends Elementor\Widget_Base
{
    public function get_name_template()
    {
        return str_replace('tbay-', '', $this->get_name());
    }

    public function get_categories()
    {
        return [ 'themename-elements' ];
    }

    public function get_name()
    {
        return 'themename-base';
    }

    /**
     * Get view template
     *
     * @param string $tpl_name
     */
    protected function get_view_template($tpl_slug, $tpl_name, $settings = [])
    {
        $located   = '';
        $templates = [];
        

        if (! $settings) {
            $settings = $this->get_settings_for_display();
        }

        if (!empty($tpl_name)) {
            $tpl_name  = trim(str_replace('.php', '', $tpl_name), DIRECTORY_SEPARATOR);
            $templates[] = 'elementor_templates/' . $tpl_slug . '-' . $tpl_name . '.php';
            $templates[] = 'elementor_templates/' . $tpl_slug . '/' . $tpl_name . '.php';
        }

        $templates[] = 'elementor_templates/' . $tpl_slug . '.php';
 
        foreach ($templates as $template) {
            if (file_exists(THEMENAME_THEMEROOT . '/' . $template)) {
                $located = locate_template( $template );
                break;
            } else {
                $located = false;
            }
        }

        if ($located) {
            include $located;
        } else {
            echo sprintf(__('Failed to load template with slug "%s" and name "%s".', 'themename'), $tpl_slug, $tpl_name);
        }
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'tbay-element tbay-element-'. $this->get_name_template());

        $this->get_view_template($this->get_name_template(), '', $settings);
    }
    
    protected function register_controls_heading($condition = array(), $full = false)
    {
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'themename'),
                'condition' => $condition,
            ]
        );

        if( $full ) {
            $this->add_control(
                'heading_list_style',
                [
                    'label'         => esc_html__('Heading Style', 'themename'),
                    'type'          => Controls_Manager::SELECT,
                    'options' => [
                        'style-1' => 'Style 01',
                        'style-2' => 'Style 02',
                        'style-border' => 'Style Border',
                        'style-border-after' => 'Style Border After',
                    ],
                    'default' => 'style-1',
                ]
            ); 
        }



        $this->register_section_heading_alignment();

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'heading_title_tag',
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
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        if ( $full ) {
            $this->add_control(
                'heading_icon',
                [
                    'label' => esc_html__( 'Choose Icon', 'themename' ),
                    'type' => Controls_Manager::ICONS,
                ]
            );
            
            $this->add_control(
                'heading_description',
                [
                    'label' => esc_html__('Description', 'themename'),
                    'label_block' => true,
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );
        }

        $this->end_controls_section();

        $this->register_section_styles_title($condition);
        $this->register_section_styles_sub_title($condition);
        
        if ($full) {
            $this->register_section_styles_icon($condition);
            $this->register_section_styles_description($condition);
        }

        $this->register_section_styles_content($condition);
    }

    private function register_section_styles_icon($condition) {
        $this->start_controls_section(
            'section_style_heading_icon',
            [
                'label' => esc_html__( 'Heading Icon', 'themename' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'align_heading_icon',
            [
                'label' => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ], 
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'justify-content: {{VALUE}}',
                ],
            ]
        ); 
        
        $this->add_responsive_control(
            'heading_icon_size',
            [
                'label' => esc_html__('Font Size', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 300,
                    ],
                ],
				'default' => [
					'unit' => 'px',
					'size' => 46,
				],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_line_height',
            [
                'label' => esc_html__('Line Height', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'themename' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );    

        $this->start_controls_tabs( 'heading_icon_tabs' );

        $this->start_controls_tab(
            'heading_icon_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'themename' ),
            ]
        );

        $this->add_control(
            'heading_icon_color',
            [
                'label' => esc_html__( 'Color', 'themename' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'color: {{VALUE}};',
                ],
                
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_icon_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'themename' ),
            ]
        );

        $this->add_control(
            'heading_icon_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'themename' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    } 

    private function register_section_heading_alignment()
    {
        $this->add_responsive_control(
            'align',
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
                'default' => 'center',
                'prefix_class' => 'align-',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'text-align: {{VALUE}}',
                ],
            ]
        ); 
    }

    private function register_section_styles_content($condition)
    {
        $this->start_controls_section(
            'section_style_heading_content',
            [
                'label' => esc_html__('Heading Content', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'heading_style_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_style_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_style_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_heading_content',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .heading-tbay-title',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_styles_title($condition)
    {
        $this->start_controls_section(
            'section_style_heading_title',
            [
                'label' => esc_html__('Heading Title', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_title_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .title',
            ]
        );

        $this->start_controls_tabs('heading_title_tabs');

        $this->start_controls_tab(
            'heading_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'heading_title_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'heading_title_bg_hover',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .title' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title_color_hover',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        
		$this->add_responsive_control(
			'heading_title_rotate',
			[
				'label' => esc_html__( 'Rotate', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default' => [
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
                'separator'    => 'before',
				'selectors' => [
					'{{WRAPPER}} .heading-tbay-title .title' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

        $this->add_responsive_control(
            'heading_title_writing_mode',
            [
                'label'     => esc_html__('Writing Mode', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'unset',
                'options'   => [
                    'unset'      => esc_html__('Unset', 'themename'),
                    'horizontal-tb' => esc_html__('Horizontal Tb', 'themename'),
                    'vertical-rl'  => esc_html__('Vertical Rl', 'themename'),
                    'vertical-lr'  => esc_html__('Vertical Lr', 'themename'),
                ],
                'selectors' => [
					'{{WRAPPER}} .heading-tbay-title .title' => 'writing-mode: {{VALUE}};',
				], 
            ]
        );

        $this->add_responsive_control(
            'heading_title_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_title_bottom_space',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_title_max_width',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title_border_active',
            [
                'label' => esc_html__('Heading Border After Style', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'hheading_title_border_after_color',
            [
                'label' => esc_html__( 'Background Color', 'themename' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'background: {{VALUE}};',
                ],
                
            ]
        );
        
        $this->add_control(
            'hheading_title_border_after_height',
            [
                'label'     => esc_html__('Increase the width on both sides', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'padding: 0 {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'width: calc(100% + 2*{{SIZE}}{{UNIT}});',
                ],
            ]
        );
        
        $this->add_control(
            'hheading_title_border_after_height_second',
            [
                'label'     => esc_html__('Height', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'hheading_title_border_after_position_bottom',
            [
                'label'     => esc_html__('Position Bottom', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'hheading_title_border_after_position_left',
            [
                'label'     => esc_html__('Position Left', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .style-border-after .tb-border-after:after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_styles_sub_title($condition)
    {
        $this->start_controls_section(
            'section_style_heading_subtitle',
            [
                'label' => esc_html__('Heading Sub Title', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_subtitle_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .subtitle',
            ]
        );

        $this->start_controls_tabs('heading_subtitle_tabs');

        $this->start_controls_tab(
            'heading_subtitle_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'heading_subtitle_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_subtitle_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'heading_subtitle_bg_hover',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .subtitle' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_subtitle_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'heading_subtitle_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_bottom_space',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_max_width',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_styles_description($condition)
    {
        $this->start_controls_section(
            'section_style_heading_description',
            [
                'label' => esc_html__('Heading Description', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_description_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .description',
            ]
        );

        $this->start_controls_tabs('heading_description_tabs');

        $this->start_controls_tab(
            'heading_description_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        
        $this->add_control(
            'heading_description_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .description' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_description_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .description' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_description_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'heading_description_bg_hover',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .description' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_description_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'heading_description_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_description_bottom_space',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_description_max_width',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .description' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function get_available_pages()
    {
        $pages = get_pages();

        $options = [];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

    protected function get_list_campaigns() {
        $args = array(
            'post_type' => 'tb_discount_campaign',
            'posts_per_page' => -1
        );

        $loop = new WP_Query($args);

        $options = [];
        if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();
            $options[get_the_ID()] = get_the_title();


        endwhile;
        endif;
        wp_reset_postdata();

        return $options;
    }

    protected function get_available_on_sale_products()
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;
        $loop = new WP_Query($args);

        $options = [];
        if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();
            $options[get_the_ID()] = get_the_title();


        endwhile;
        endif;
        wp_reset_postdata();

        return $options;
    }

    protected function register_style_product_item()
    {

        $this->start_controls_section(
            'section_style_product_item',
            [
                'label' => esc_html__('Product Item', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_style_product_item',
            [
                'label' => esc_html__('Product Item', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style_product_item',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'        => 'style_product_item_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .product-block',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'style_product_item_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_product_item_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_style_product_item_title',
            [
                'label' => esc_html__('Product Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'style_product_item_title_typography',
                'selector' => '{{WRAPPER}} .product-block .name a',
            ]
        );

        $this->add_responsive_control(
            'style_product_item_title_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_product_item_title_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('style_product_item_title_tabs');

        $this->start_controls_tab(
            'style_product_item_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'style_product_item_title_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .name a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_product_item_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
 
        $this->add_control(
            'style_product_item_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .name a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'heading_style_product_item_sub_title',
            [
                'label' => esc_html__('Product Sub Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'style_product_item_sub_title_typography',
                'selector' => '{{WRAPPER}} .product-block .tbay-subtitle',
            ]
        );

        $this->add_responsive_control(
            'style_product_item_sub_title_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .tbay-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_product_item_sub_title_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .tbay-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('style_product_item_sub_title_tabs');

        $this->start_controls_tab(
            'style_product_item_sub_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'style_product_item_sub_title_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .tbay-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_product_item_sub_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
 
        $this->add_control(
            'style_product_item_sub_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .tbay-subtitle:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'heading_style_product_item_price',
            [
                'label' => esc_html__('Product Price', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'style_product_item_price_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'style_product_item_price_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-block .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'style_product_item_price_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .woocs_price_code,
                    {{WRAPPER}} .product-block .price,
                    {{WRAPPER}} .product-block .price del .woocommerce-Price-amount,
                    {{WRAPPER}} .product-block .price ins .woocommerce-Price-amount,
                    {{WRAPPER}} .product-block .woocs_price_code ins' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'heading_style_product_item_rating',
            [
                'label' => esc_html__('Product Rating', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style_product_item_rating_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-block .caption .rating .count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function get_available_menus()
    {
        if ( themename_wpml_is_activated() ) {
            return $this->get_available_menus_wpml();
        } else {
            return $this->get_available_menus_default();
        }
    }

    protected function get_available_menus_default()
    {
        $menus = wp_get_nav_menus();
        $options = [];

        if ($menus) {
            foreach ($menus as $menu) {
                $options[ themename_get_transliterate($menu->slug) ] = $menu->name;
            }
        }

        return $options;
    }

    protected function get_available_menus_wpml()
    {
        global $sitepress;
        $menus = wp_get_nav_menus();

        $options = [];

        $current_lang = apply_filters('wpml_current_language', null);
        ;
        if ($menus) {
            foreach ($menus as $menu) {
                $menu_details = $sitepress->get_element_language_details($menu->term_taxonomy_id, 'tax_nav_menu');
                if (isset($menu_details->language_code) && $menu_details->language_code === $current_lang) {
                    $options[ themename_get_transliterate($menu->slug) ] = $menu->name;
                }
            }
        }

        return $options;
    }
    
    public function render_element_heading()
    {
        $heading_title = $heading_list_style = $heading_icon = $heading_title_tag = $heading_description = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        if (!empty($heading_subtitle) || !empty($heading_title)) : ?>
            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title <?php echo esc_attr($heading_list_style); ?>">
                <?php 
                    if( $heading_list_style === 'style-2' ) {
                        $this->render_item_icon($heading_icon);

                        echo ( !empty($heading_title) ) ? '<span class="title">'. trim($heading_title) .'</span>' : '';  

                        echo ( !empty($heading_subtitle) ) ? '<span class="subtitle">'. trim($heading_subtitle) .'</span>' : '';	

                        echo ( !empty($heading_description) ) ? '<span class="description">'. trim($heading_description) .'</span>' : '';  	
                    } else if( $heading_list_style === 'style-border-after' ) {
                        $this->render_item_icon($heading_icon);

                        echo ( !empty($heading_title) ) ? '<span class="title tb-border-after">'. trim($heading_title) .'</span>' : '';  

                        echo ( !empty($heading_subtitle) ) ? '<span class="subtitle">'. trim($heading_subtitle) .'</span>' : '';	

                        echo ( !empty($heading_description) ) ? '<span class="description">'. trim($heading_description) .'</span>' : '';  	
                    } else {
                        echo ( !empty($heading_subtitle) ) ? '<span class="subtitle">'. trim($heading_subtitle) .'</span>' : '';

                        echo ( !empty($heading_title) ) ? '<span class="title">'. trim($heading_title) .'</span>' : '';  	

                        echo ( !empty($heading_description) ) ? '<span class="description">'. trim($heading_description) .'</span>' : '';

                        $this->render_item_icon($heading_icon);
                    }
                ?>
            </<?php echo trim($heading_title_tag); ?>>
        <?php endif;
    }

    
    protected function get_template_product_grid()
    {
        return apply_filters('themename_get_template_product_grid', 'v1');
    }

    protected function get_template_product_vertical()
    {
        return apply_filters('themename_get_template_product_vertical', 'vertical');
    }

    protected function get_template_product()
    {
        return apply_filters('themename_get_template_product', 'v1');
    }

    protected function get_product_type()
    {
        $type = [
            'newest' => esc_html__('Newest Products', 'themename'),
            'on_sale' => esc_html__('On Sale Products', 'themename'),
            'best_selling' => esc_html__('Best Selling', 'themename'),
            'top_rated' => esc_html__('Top Rated', 'themename'),
            'featured' => esc_html__('Featured Product', 'themename'),
            'random_product' => esc_html__('Random Product', 'themename'),
        ];

        return apply_filters('themename_woocommerce_product_type', $type);
    }

    protected function get_title_product_type($key)
    {
        $array = $this->get_product_type();

        return $array[$key];
    }

    protected function get_product_categories($number = '')
    {
        $args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        );
        if ($number === 0) {
            return;
        }
        if (!empty($number) && $number !== -1) {
            $args['number'] = $number;
        }
       

        $category = get_terms($args);
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[themename_get_transliterate($category->slug)] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }

    protected function get_cat_operator()
    {
        $operator = [
            'AND' => esc_html__('AND', 'themename'),
            'IN' => esc_html__('IN', 'themename'),
            'NOT IN' => esc_html__('NOT IN', 'themename'),
        ];

        return apply_filters('themename_woocommerce_cat_operator', $operator);
    }

    protected function get_woo_order_by()
    {
        $oder_by = [
            'date' => esc_html__('Date', 'themename'),
            'title' => esc_html__('Title', 'themename'),
            'id' => esc_html__('ID', 'themename'),
            'popularity' => esc_html__('Popularity', 'themename'),
            'rand' => esc_html__('Random', 'themename'),
            'menu_order' => esc_html__('Menu Order', 'themename'),
        ];

        return apply_filters('themename_woocommerce_oder_by', $oder_by);
    }

    protected function get_woo_order()
    {
        $order = [
            'asc' => esc_html__('ASC', 'themename'),
            'desc' => esc_html__('DESC', 'themename'),
        ];

        return apply_filters('themename_woocommerce_order', $order);
    }

    protected function register_woocommerce_order()
    {
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'top_rated',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'random_product',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'best_selling',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'top_rated',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'random_product',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'best_selling',
                        ],
                    ],
                ],
            ]
        );
    }

    protected function register_woocommerce_categories_operator()
    {
        $categories = $this->get_product_categories();

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'themename'),
                'type' => Controls_Manager::SELECT2,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => esc_html__('Category Operator', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => $this->get_cat_operator(),
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );
    }

    protected function get_woocommerce_tags()
    {
        $tags = array();
        
        $args = array(
            'order' => 'ASC',
        );

        $product_tags = get_terms('product_tag', $args);

        foreach ($product_tags as $key => $tag) {
            $tags[$tag->slug] = $tag->name . ' (' .$tag->count .')';
        }

        return $tags;
    }
    public function settings_layout()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!isset($layout_type)) {
            return;
        }

        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if (isset($rows) && !empty($rows)) {
            $this->add_render_attribute('row', 'class', 'rows-'. $rows);
        }

        if ($layout_type === 'carousel') {
            $this->settings_carousel($settings);
        } else {
            $this->settings_responsive($settings);
        }
    }
    
    protected function settings_responsive($settings)
    {

        /*Add class reponsive grid*/
        $this->add_render_attribute(
            'row',
            [
                'class' => [ 'row', 'grid' ],
                'data-xlgdesktop' =>  $settings['column'],
                'data-desktop' =>  $settings['col_desktop'],
                'data-desktopsmall' =>  $settings['col_desktopsmall'],
            ]
        );

        $column_tablet = ( !empty($settings['column_tablet']) ) ? $settings['column_tablet'] : 3;
        $column_mobile = ( !empty($settings['column_mobile']) ) ? $settings['column_mobile'] : 2;

        $this->add_render_attribute('row', 'data-tablet', $column_tablet);
        $this->add_render_attribute('row', 'data-landscape', $settings['col_landscape']);
        $this->add_render_attribute('row', 'data-mobile', $column_mobile);
    }

    protected function settings_carousel($settings)
    {
        $column_tablet  = ( !empty($settings['column_tablet']) ) ? $settings['column_tablet'] : 3;
        $column_mobile  = ( !empty($settings['column_mobile']) ) ? $settings['column_mobile'] : 2;
        $rows           = ( !empty($settings['rows']) ) ? $settings['rows'] : 1;

        $this->add_render_attribute('row', 'class', ['owl-carousel', 'scroll-init']);
        $this->add_render_attribute('row', 'data-carousel', 'owl');

        $this->add_render_attribute('row', 'data-items', $settings['column']);
        $this->add_render_attribute('row', 'data-desktopslick', $settings['col_desktop']);
        $this->add_render_attribute('row', 'data-desktopsmallslick', $settings['col_desktopsmall']);
        $this->add_render_attribute('row', 'data-tabletslick', $column_tablet);
        $this->add_render_attribute('row', 'data-landscapeslick', $settings['col_landscape']);
        $this->add_render_attribute('row', 'data-mobileslick', $column_mobile);
        $this->add_render_attribute('row', 'data-rows', $rows);

        $this->add_render_attribute('row', 'data-speed', $settings['speed']);

        if( $settings['carousel_blur'] === 'yes' ) { 
            $this->add_render_attribute('wrapper', 'class', 'carousel-blur');
            $this->set_render_attribute('row', 'data-loop', 'true'); 
        } else {
            $this->add_render_attribute('row', 'data-loop', $settings['loop'] === 'yes' ? true : false);
        }

        $this->add_render_attribute('row', 'data-nav', $settings['navigation'] === 'yes' ? true : false);
        $this->add_render_attribute('row', 'data-pagination', $settings['pagination'] === 'yes' ? true : false);

        if (!empty($settings['autospeed'])) {
            $this->add_render_attribute('row', 'data-autospeed', $settings['autospeed']);
        }
  
        $this->add_render_attribute('row', 'data-auto', $settings['auto'] === 'yes' ? true : false);
        $this->add_render_attribute('row', 'data-unslick', $settings['disable_mobile'] === 'yes' ? true : false);
    }

    protected function get_widget_field_img($image, $class = '')
    {
        $image_id   = $image['id'];
        $img  = '';

        if (!empty($image_id)) {
            $img = wp_get_attachment_image($image_id, 'full', false, array( 'class' => $class ));
        } elseif (!empty($image['url'])) {
            $img = '<img src="'. $image['url'] .'">';
        }

        return $img;
    }

    protected function print_render_widget_field_img($image, $class = '')
    {
        $img  = $this->get_widget_field_img($image, $class = '');

        echo trim($img);
    }

    protected function render_item_icon($selected_icon)
    {
        if (! isset($selected_icon['icon']) && ! Icons_Manager::is_migration_allowed()) {
            // add old default
            $selected_icon['icon'] = 'fa fa-star';
        }
        $has_icon = ! empty($selected_icon['icon']);

        if ($has_icon) {
            $this->add_render_attribute('i', 'class', $selected_icon['icon']);
            $this->add_render_attribute('i', 'aria-hidden', 'true');
        }
        
        if (! $has_icon && ! empty($selected_icon['value'])) {
            $has_icon = true;
        }
        $migrated = isset($selected_icon['__fa4_migrated']['selected_icon']);
        $is_new = ! isset($selected_icon['icon']) && Icons_Manager::is_migration_allowed();
        
        Icons_Manager::enqueue_shim();

        if (!$has_icon) {
            return;
        }
        
        if ($is_new || $migrated) {
            Icons_Manager::render_icon($selected_icon, [ 'aria-hidden' => 'true' ]);
        } elseif (! empty($selected_icon['icon'])) {
            ?><i <?php $this->print_render_attribute_string('i'); ?>></i><?php
        }
    }
}