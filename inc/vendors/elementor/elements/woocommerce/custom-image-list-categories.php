<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Custom_Image_List_Categories')) {
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
class Lasa_Elementor_Custom_Image_List_Categories extends Lasa_Elementor_Carousel_Base
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
        return 'tbay-custom-image-list-categories';
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
        return esc_html__('Lasa Custom Image List Categories', 'lasa');
    }

    public function get_categories()
    {
        return [ 'lasa-elements', 'woocommerce-elements'];
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
        return 'eicon-product-categories';
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
        return ['slick', 'lasa-custom-slick'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'custom-image-list-categories' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Custom Image List Categories', 'lasa'),
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'lasa'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = $this->register_list_category_repeater();

        $this->add_control(
            'custom_image_list_category',
            [
                'label' => esc_html__('List Categories Items', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
                
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'lasa'),
                    'carousel'  => esc_html__('Carousel', 'lasa'),
                ],
            ]
        );

        $this->add_control(
            'style_type',
            [
                'label'     => esc_html__('Style Type', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'v1',
                'options'   => [
                    'v1'      => esc_html__('Style 1', 'lasa'),
                    'v2'  => esc_html__('Style 2', 'lasa'),
                    'v3'  => esc_html__('Style 3', 'lasa'),
                    'v4'  => esc_html__('Style 4', 'lasa'),
                    'v5'  => esc_html__('Style 5', 'lasa'),
                ],
            ]
        );



        $this->add_control(
            'cat_list_align',
            [
                'label' => esc_html__('Align', 'lasa'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lasa'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lasa'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lasa'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'text-align: {{VALUE}} !important',
                    '{{WRAPPER}} .content' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_control(
            'display_count_category',
            [
                'label'     => esc_html__('Show Count Category', 'lasa'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
            ]
        );

        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'lasa'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
            ]
        );
        $this->add_control(
            'position_show_all',
            [
                'label'     => esc_html__('Position', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    'top' => esc_html__('Top', 'lasa'),
                    'bottom' => esc_html__('Bottom', 'lasa'),
                ],
                'default' => 'bottom',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'text_show_all',
            [
                'label'     => esc_html__('Text Show All', 'lasa'),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'See all categories',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Show All', 'lasa'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'library' => 'tbay-custom',
                    'value'   => 'tb-icon tb-icon-angle-right'
                ],

                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

        $this->register_section_styles_custom_image_list_categories();
    }

    private function register_list_category_repeater()
    {
        $categories = $this->get_product_categories();
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'category',
            [
                'label' => esc_html__('Choose category', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );

        $repeater->add_control(
            'type',
            [
                'label' => esc_html__('Type Custom', 'lasa'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'image' => [
                        'title' => esc_html__('Image', 'lasa'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'lasa'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default'  =>'image'
            ]
        );

        $repeater->add_control(
            'type_icon',
            [
                'label' => esc_html__('Choose Icon', 'lasa'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-question',
                    'library' => 'simple-line-icons',
                ],
                'condition' => [
                    'type' => 'icon'
                ]
            ]
        );

        $repeater->add_control(
            'type_image',
            [
                'label' => esc_html__('Choose Image', 'lasa'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'type' => 'image'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );
        
        $repeater->add_control(
            'display_custom',
            [
                'label' => esc_html__('Show Custom Link', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        
        $repeater->add_control(
            'custom_link',
            [
                'label' => esc_html__('Custom Link', 'lasa'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'display_custom' => 'yes'
                ],
                'placeholder' => esc_html__('https://your-link.com', 'lasa'),
            ]
        );

        return $repeater;
    }

    private function register_section_styles_custom_image_list_categories()
    {
        $this->start_controls_section(
            'section_style_custom_image_list_categories',
            [
                'label' => esc_html__('Categories Item ', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->resgiter_heading_style_content();
        $this->resgiter_heading_style_img();
        $this->resgiter_heading_style_icon();
        $this->resgiter_heading_style_title();
        $this->resgiter_heading_style_count();
        $this->end_controls_section();
    }

    private function resgiter_heading_style_content()
    {
        $this->add_control(
            'heading_style_custom_image_list_categories_content',
            [
                'label' => esc_html__('Content Item', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('list_categories_content_tabs');

        $this->start_controls_tab(
            'list_categories_content_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_content_bg',
            [
                'label' => esc_html__('Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_content_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_content_color_hover',
            [
                'label' => esc_html__('Hover Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .item',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'list_categories_content_radius',
            [
                'label' => esc_html__('Border Radius', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'list_categories_content_padding',
            [
                'label'      => esc_html__('Padding', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_categories_content_margin',
            [
                'label'      => esc_html__('Margin', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .custom-image-list-categories' => 'margin: -{{TOP}}{{UNIT}} -{{RIGHT}}{{UNIT}} -{{BOTTOM}}{{UNIT}} -{{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
    }

    private function resgiter_heading_style_img()
    {
        $this->add_control(
            'heading_style_custom_image_list_categories_img',
            [
                'label' => esc_html__('Image', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'list_categories_img_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item-cat img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_categories_img_radius',
            [
                'label' => esc_html__('Border Radius', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-cat img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('list_categories_img_tabs');

        $this->start_controls_tab(
            'list_categories_img_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_img_bg',
            [
                'label' => esc_html__('Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat img' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_img_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_img_color_hover',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat:hover img' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    private function resgiter_heading_style_icon()
    {
        $this->add_control(
            'heading_style_custom_image_list_categories_icon',
            [
                'label' => esc_html__('Icon', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'list_categories_icon_size',
            [
                'label' => esc_html__('Font Size', 'lasa'),
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
                    '{{WRAPPER}} .cat-icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_categories_icon_line_height',
            [
                'label' => esc_html__('Line Height', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_categories_icon_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;',
                ],
            ]
        );

        $this->start_controls_tabs('list_categories_icon_tabs');

        $this->start_controls_tab(
            'list_categories_icon_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_icon_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_icon_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_icon_color_hover',
            [
                'label' => esc_html__('Hover Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-icon:hover .cat-icon > i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    private function resgiter_heading_style_title()
    {
        $this->add_control(
            'heading_style_custom_image_list_categories_title',
            [
                'label' => esc_html__('Title', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'list_categories_title_typography',
                'selector' => '{{WRAPPER}} .cat-name',
            ]
        );

        $this->add_responsive_control(
            'list_categories_title_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_categories_title_margin',
            [
                'label' => esc_html__('Margin', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('list_categories_title_tabs');

        $this->start_controls_tab(
            'list_categories_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_title_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-name' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'list_categories_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat .cat-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    private function resgiter_heading_style_count() 
    {
        $this->add_control(
            'heading_style_custom_image_list_categories_count_item',
            [
                'label' => esc_html__('Count item', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'list_categories_count_item_typography',
                'selector' => '{{WRAPPER}} .count-item',
            ]
        );

        $this->add_responsive_control(
            'list_categories_count_item_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .count-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_categories_count_item_margin',
            [
                'label' => esc_html__('Margin', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .count-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_categories_count_item_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .count-item' => 'color: {{VALUE}};',
                ],
            ]
        );
        
    }


    public function render_item_content($item, $attribute, $display_count_category)
    {
        extract($item);
        $settings = $this->get_settings_for_display();
        $obj_cat = get_term_by('slug', $category, 'product_cat');

        if (!is_object($obj_cat)) return;

        $name   = $obj_cat->name;
        $count  = $obj_cat->count;
        if (!empty($custom_link['url']) && isset($custom_link) && $display_custom ==='yes') {
            $url_category       = $custom_link['url'];
            $is_external        = $custom_link['is_external'];
            $nofollow           = $custom_link['nofollow'];
            if ($is_external === 'on') {
                $attribute .= ' target="_blank"';
            }

            if ($nofollow === 'on') {
                $attribute .= ' rel="nofollow"';
            }
        } else {
            $url_category =  get_term_link($category, 'product_cat');

            if( is_wp_error($url_category) ) return;
        } 
        ?>
        <?php $this->render_item_type($type, $url_category, $type_icon, $type_image); ?>
            <div class="content">
                <a href="<?php echo esc_url($url_category)?>" class="cat-name" <?php echo trim($attribute); ?>>
                    <span class="name">
                        <?php 
                            echo trim($name);
                            
                            if( $display_count_category === 'yes' &&  $settings['style_type'] === 'v2' ) {
                                echo '<span class="count-item">'. trim($count) .'</span>'; 
                            }  
                        ?>
                    </span>
                </a>
                <?php if ($display_count_category === 'yes' && ( $settings['style_type'] === 'v1' || $settings['style_type'] === 'v3' || $settings['style_type'] === 'v4' || $settings['style_type'] === 'v5' ) ) {
                        ?><span class="count-item">
                    <?php echo trim($count).' '.esc_html__('products', 'lasa'); ?>
                </span><?php
                    } ?>

            </div>
        <?php
    }

    public function render_item_image($type_image)
    {
        if ( empty($type_image['id']) ) return;

        echo wp_get_attachment_image($type_image['id'], 'full');
    }
    public function render_item_type($type, $url_category, $type_icon, $type_image)
    {
        if ( empty($url_category) ) return;


        if ($type === 'icon') {
            ?>
            <a href="<?php echo esc_url($url_category)?>" class='cat-icon'>
                <?php $this->render_item_icon($type_icon); ?>
            </a>
            <?php
                    } elseif ($type ==='image') {
                        ?>
            <a href="<?php echo esc_url($url_category)?>" class='cat-image'>
                <?php $this->render_item_image($type_image); ?>
            </a>
            <?php
        }
    }

    protected function render_element_heading_2()
    {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract($settings);
        $url_show_all = get_permalink(wc_get_page_id('shop'));
        $check_show_all_top = $settings['show_all'] === 'yes' && $settings['position_show_all'] === 'top' && (!empty($settings['text_show_all']) || !empty($settings['icon_show_all']['value']));

        if ($check_show_all_top || !empty($heading_subtitle) || !empty($heading_title)) {
            ?>
            <div class="wrapper-title-heading">
                <?php
                if (!empty($heading_subtitle) || !empty($heading_title)) : ?>
                    <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">
                        <?php if (!empty($heading_title)) : ?>
                        <span class="title"><?php echo trim($heading_title); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($heading_subtitle)) : ?>
                        <span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
                        <?php endif; ?>
                    </<?php echo trim($heading_title_tag); ?>>
                <?php endif;
                                
                if ($check_show_all_top) {?> 
                <div class="readmore-wrapper"><a href="<?php echo esc_url($url_show_all) ?>"
                    class="show-all"><span><?php echo trim($settings['text_show_all']) ?></span>
                    <?php if (!empty($settings['icon_show_all']['value'])) {
                            echo '<i class="'. esc_attr($settings['icon_show_all']['value']) .'"></i>';
                        } ?>
                </a></div> 
                <?php } ?>
            </div>
            <?php
        }
    }
}
$widgets_manager->register(new Lasa_Elementor_Custom_Image_List_Categories());