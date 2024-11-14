<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Feature_List')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Feature_List extends Themename_Elementor_Carousel_Base
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
        return 'xptheme-feature-list';
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
        return esc_html__('Themename Feature List', 'themename');
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
        return 'eicon-post-list';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends()
    {
        return ['slick', 'themename-custom-slick'];
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
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'themename'),
                    'carousel'  => esc_html__('Carousel', 'themename'),
                ],
            ]
        );

        $repeater = $this->register_list_feature_repeater();

        $this->add_control(
            'custom_list_feature',
            [
                'label' => esc_html__('List Feature Items', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
                
            ]
        );

        $this->add_responsive_control(
			'feature_list_position',
			[
				'label' => esc_html__( 'Item Position', 'themename' ),
				'type' => Controls_Manager::CHOOSE,
				'mobile_default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themename' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'themename' ),
						'icon' => 'eicon-v-align-top',
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
            'feature_list_align',
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
                'condition' => [
                    'feature_list_position' => ['top', ''],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

        $this->register_section_style_feature_list_items();
        $this->register_section_style_feature_list_item();
        $this->register_section_style_feature_item_img();
        $this->register_section_style_feature_item_icon();
        $this->register_section_style_feature_item_title();
    }

    private function register_list_feature_repeater()
    {
        $repeater = new \Elementor\Repeater();


        
        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Item Title', 'themename'),
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'item_type',
            [
                'label' => esc_html__('Type Custom', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'image' => [
                        'title' => esc_html__('Image', 'themename'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'themename'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default'  =>'icon'
            ]
        );

        $repeater->add_control(
            'item_type_icon',
            [
                'label' => esc_html__('Choose Icon', 'themename'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-question',
                    'library' => 'simple-line-icons',
                ],
                'condition' => [
                    'item_type' => 'icon'
                ]
            ]
        );

        $repeater->add_control(
            'item_type_image',
            [
                'label' => esc_html__('Choose Image', 'themename'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'item_type' => 'image'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        return $repeater;
    }

    private function register_section_style_feature_list_items()
    {
        $this->start_controls_section(
            'section_style_feature_list_items',
            [
                'label' => esc_html__('Feature List Items', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('feature_list_items_tabs');

        $this->start_controls_tab(
            'feature_list_items_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'feature_list_items_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .list-items' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_list_items_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'feature_list_items_color_hover',
            [
                'label' => esc_html__('Hover Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .list-items:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'feature_list_items_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .items',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'feature_list_items_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .list-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'feature_list_items_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .list-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'feature_list_items_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .list-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

    }

    private function register_section_style_feature_list_item()
    {
        $this->start_controls_section(
            'section_style_feature_list_item',
            [
                'label' => esc_html__('Feature Item', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('feature_list_item_tabs');

        $this->start_controls_tab(
            'feature_list_item_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'feature_list_item_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item .content' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_list_item_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'feature_list_item_color_hover',
            [
                'label' => esc_html__('Hover Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item:hover .content' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'feature_list_item_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .item .content',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'feature_list_item_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'feature_list_item_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'feature_list_item_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item .content,
                    {{WRAPPER}} .owl-carousel:not(.slick-slider)[data-items] div.item .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .feature-list' => 'margin: -{{TOP}}{{UNIT}} -{{RIGHT}}{{UNIT}} -{{BOTTOM}}{{UNIT}} -{{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_style_feature_item_img()
    {
        $this->start_controls_section(
            'section_style_feature_item_image',
            [
                'label' => esc_html__('Feature Item Image', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'feature_item_image_logo',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 2000,
                    ],
                    
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_image_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_image_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_image_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_style_feature_item_icon()
    {
        $this->start_controls_section(
            'section_style_feature_item_icon',
            [
                'label' => esc_html__('Feature Item Icon', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'feature_item_icon_size',
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
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .item-icon svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_icon_line_height',
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
                    '{{WRAPPER}} .item-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_icon_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'feature_item_icon_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .content-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs('feature_item_icon_tabs');

        $this->start_controls_tab(
            'feature_item_icon_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'feature_item_icon_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .item-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_item_icon_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'feature_item_icon_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .item-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    private function register_section_style_feature_item_title()
    {
        $this->start_controls_section(
            'section_style_feature_item_title',
            [
                'label' => esc_html__('Feature Item Title', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feature_item_title_typography',
                'selector' => '{{WRAPPER}} .content-title',
            ]
        );

        $this->add_responsive_control(
            'feature_item_title_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs('feature_item_title_tabs');

        $this->start_controls_tab(
            'feature_item_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'feature_item_title_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .content-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_item_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'feature_item_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item:hover .content-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function render_item_content($item)
    {
        extract($item);

        $class_icon = ( $item_type === 'icon' ) ? 'elementor-icon' : '';
        ?>
        <div class="content">
            <?php
            if( !empty($item_type_icon['value']) || !empty($item_type_image['id']) ) {
                echo '<div class="content-'. esc_attr($item_type) .' '. esc_attr($class_icon) .'">';
            }
                
                if ($item_type === 'icon') {
                    $this->render_item_icon($item_type_icon);
                } else {
                    $this->render_item_image($item_type_image);
                }

            if(!empty($item_type_icon['value']) || !empty($item_type_image['id'])) {
                echo '</div>';
            }

            echo '<h3 class="content-title">'. trim($item_title) .'</h3>';
            ?>
        </div>
        <?php
    }

    public function render_item_image($image)
    {
        if ( empty($image['id']) ) return;

        echo wp_get_attachment_image($image['id'], 'full');
    }
}
$widgets_manager->register(new Themename_Elementor_Feature_List());