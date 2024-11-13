<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Image_Tab')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Image_Tab extends Themename_Elementor_Widget_Base
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
        return 'tbay-image-tab';
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
        return esc_html__('Themename Image Tab', 'themename');
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
            ]
        );


        $this->end_controls_section();

        $this->style_Image_Tab_title_section();
        $this->style_Image_Tab_content_section();
    }

    private function register_tab_repeater()
    {
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'tab_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label'   => esc_html__('Choose image', 'themename'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        return $repeater;
    }

    private function style_Image_Tab_title_section()
    {
        $this->start_controls_section(
            'section_style_image_tab_title',
            [
                'label' => esc_html__('Image Tab Title', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_bg_wrapper',
            [
                'label' => esc_html__('Background Wraper', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'image_bg_wrapper',
				'selector' => '{{WRAPPER}} .tab-image-wrapper::after',
			]
		);

        $this->add_control(
            'heading_tabtitle',
            [
                'label' => esc_html__('Tab Title Wraper', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_responsive_control(
			'image_z_index',
			[
				'label' => esc_html__( 'Z-Index', 'themename' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'selectors' => [
					'{{WRAPPER}} .tab-image-wrapper::after' => 'z-index: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'image_tab_title_align',
            [
                'label' => esc_html__('Align Tab Title', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .nav-link' => 'align-items: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_tab_title_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'image_tab_title_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-image-title .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_tab_title_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-image-title .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'image_under_title_bg',
            [
                'label' => esc_html__('Background under title', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link.active:after,
                    {{WRAPPER}} .nav-image-title .nav-link:hover:after' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        ); 

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_tab_title_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .nav-image-title .title',
            ]
        ); 

        $this->start_controls_tabs('image_tab_title_tabs');

        $this->start_controls_tab(
            'image_tab_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'image_tab_title_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link:not(.active) .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'image_tab_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'image_tab_title_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link.active .title,
                    {{WRAPPER}} .nav-image-title .nav-link:hover .title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
			'image_tab_title_space',
			[
				'label' => esc_html__( 'Spacing', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nav-image-title .nav-link .title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
            'heading_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_tab_subtitle_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .nav-image-title .subtitle',
            ]
        ); 

        $this->start_controls_tabs('image_tab_subtitle_tabs');

        $this->start_controls_tab(
            'image_tab_subtitle_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'image_tab_subtitle_color',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link:not(.active) .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'image_tab_subtitle_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'image_tab_subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-title .nav-link.active .subtitle,
                    {{WRAPPER}} .nav-image-title .nav-link:hover .subtitle' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
			'image_tab_subtitle_space',
			[
				'label' => esc_html__( 'Spacing', 'themename' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nav-image-title .nav-link .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->end_controls_section();
    }

    private function style_Image_Tab_content_section()
    {
        $this->start_controls_section(
            'section_style_Image_Tab_content',
            [
                'label' => esc_html__('Image Content', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_tab_content_align',
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
                    '{{WRAPPER}} .nav-image-content .content' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_tab_content_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nav-image-content .content,
                    {{WRAPPER}} .nav-image-content .content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'image_tab_content_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-image-content .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_tab_content_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-image-content .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function render_tabs_title($tabs, $id) {
        $count = 0;
        ?>
        <div class="container nav-image-title-wrapper">
            <div class="nav nav-tabs nav-image-title" id="tab-nav-image-<?php echo esc_attr( $id ); ?>" role="tablist">
                <?php foreach ($tabs as $key) : ?>
                    <?php 
                        $class_active = ( $count === 0 ) ? 'active' : '';
                        $selected = ( $count === 0 ) ? 'true' : 'false';
                    ?>

                    <button class="nav-link <?php echo esc_attr( $class_active ); ?>" id="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" data-bs-toggle="tab" data-bs-target="#nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" type="button" role="tab" aria-controls="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" aria-selected="<?php echo esc_attr( $selected ) ?>"><span class="subtitle"><?php echo trim($key['tab_subtitle']); ?></span><span class="title"><?php echo trim($key['tab_title']); ?></span></button>

                    <?php $count++; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function render_tabs_content($tabs, $id) {
        $count = 0;
        ?>
        <div class="tab-content nav-image-content" id="nav-content-image-<?php echo esc_attr( $id ); ?>">
            <?php foreach ($tabs as $key) : ?>
            <?php 
                $class_active = ( $count === 0 ) ? ' active' : '';
            ?> 

            <div class="tab-pane <?php echo esc_attr( $class_active ); ?>" id="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" role="tabpanel" aria-labelledby="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>">
                <div class="content">
                    <?php echo  Elementor\Group_Control_Image_Size::get_attachment_image_html($key, 'tab_image'); ?>
                </div>
            </div>

            <?php $count++; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Image_Tab());