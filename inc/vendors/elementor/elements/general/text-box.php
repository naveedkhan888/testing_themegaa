<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Text_Box')) {
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
class Themename_Elementor_Text_Box extends Themename_Elementor_Widget_Base
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
        return 'tbay-text-box';
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
        return esc_html__('Themename Text Box', 'themename');
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
        return 'eicon-info-box';
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
                'label' => esc_html__('Text Box', 'themename'),
            ]
        );

        $this->add_control(
            'heading_text_heading',
            [
                'label' => esc_html__('Heading', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

    
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Heading', 'themename'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'heading_content',
            [
                'label' => esc_html__('Content', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'text_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'text_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->end_controls_section();

        $this->style_text_box();
    }

    protected function style_text_box()
    {
        $this->start_controls_section(
            'section_style_text_box',
            [
                'label' => esc_html__('Box', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Heading Position', 'themename' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'mobile_default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themename' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themename' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-position-',
			]
		);

        $this->add_control(
			'content_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'themename' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'themename' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'themename' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'themename' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'middle',
				'toggle' => false,
				'prefix_class' => 'elementor-vertical-align-',
			]
		);

        $this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'themename' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themename' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'themename' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themename' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'themename' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-text-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text_box_content',
            [
                'label' => esc_html__('Style Content', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_style_text_heading',
            [
                'label' => esc_html__('Heading', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
			'text_heading_space',
			[
				'label' => esc_html__( 'Spacing', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--text-box-heading-margin: {{SIZE}}{{UNIT}}',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_box_heading_typography',
                'selector' => '{{WRAPPER}} .elementor-text-box-heading',
            ]
        ); 
        
        $this->add_control(
            'enable_heading_background_text',
            [
                'label'   => esc_html__('Enable Background Text', 'themename'),
                'type'    => Controls_Manager::SWITCHER,
                'prefix_class' => 'show-heading-bg-text-',
                'default' => '',
            ]
        );
        
        $this->start_controls_tabs('text_box_heading_tabs');
        
        $this->start_controls_tab(
            'text_box_heading_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_heading_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'enable_heading_background_text!' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-heading' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_heading_background',
                'condition' => [
                    'enable_heading_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-heading',
            ]
        );
        
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'text_box_heading_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_heading_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'enable_heading_background_text!' => 'yes'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-heading' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_heading_background_hover',
                'condition' => [
                    'enable_heading_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-heading',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_control(
            'heading_style_text_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
			'text_box_title_bottom_space',
			[
				'label' => esc_html__( 'Spacing', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-text-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_box_title_typography',
                'selector' => '{{WRAPPER}} .elementor-text-box-title',
            ]
        ); 
        
        $this->add_control(
            'enable_title_background_text',
            [
                'label'   => esc_html__('Enable Background Text', 'themename'),
                'type'    => Controls_Manager::SWITCHER,
                'prefix_class' => 'show-title-bg-text-',
                'default' => '',
            ]
        );
        
        $this->start_controls_tabs('text_box_title_tabs');
        
        $this->start_controls_tab(
            'text_box_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_title_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'enable_title_background_text!' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_background_title',
                'condition' => [
                    'enable_title_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-title',
            ]
        );
        
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'text_box_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_title_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'enable_title_background_text!' => 'yes'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_title_background_hover',
                'condition' => [
                    'enable_title_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-title',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->add_control(
            'heading_style_text_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_box_subtitle_typography',
                'selector' => '{{WRAPPER}} .elementor-text-box-subtitle',
            ]
        ); 
        
        $this->add_control(
            'enable_subtitle_background_text',
            [
                'label'   => esc_html__('Enable Background Text', 'themename'),
                'type'    => Controls_Manager::SWITCHER,
                'prefix_class' => 'show-subtitle-bg-text-',
                'default' => '',
            ]
        );
        
        $this->start_controls_tabs('text_box_subtitle_tabs');
        
        $this->start_controls_tab(
            'text_box_subtitle_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_subtitle_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'enable_subtitle_background_text!' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_background_subtitle',
                'condition' => [
                    'enable_subtitle_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-heading',
            ]
        );
        
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'text_box_subtitle_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        
        $this->add_control(
            'text_box_subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'enable_subtitle_background_text!' => 'yes'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-subtitle' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'text_box_subtitle_background_hover',
                'condition' => [
                    'enable_subtitle_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-text-box-wrapper:hover .elementor-text-box-subtitle',
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}
$widgets_manager->register(new Themename_Elementor_Text_Box());