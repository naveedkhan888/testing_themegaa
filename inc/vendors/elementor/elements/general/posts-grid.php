<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Posts_Grid')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Themename_Elementor_Posts_Grid extends Themename_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'xptheme-posts-grid';
    }

    public function get_title()
    {
        return esc_html__('Themename Posts Grid', 'themename');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_keywords()
    {
        return [ 'post-grid', 'blog', 'post' ];
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['slick', 'themename-custom-slick'];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of posts', 'themename'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of posts to show ( -1 = all )', 'themename'),
                'default' => 6,
                'min'  => -1
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'themename'),
                'type' => Controls_Manager::HEADING,
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

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => esc_html__('Date', 'themename'),
                    'post_title' => esc_html__('Title', 'themename'),
                    'rand'       => esc_html__('Random', 'themename'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => esc_html__('ASC', 'themename'),
                    'desc' => esc_html__('DESC', 'themename'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'themename'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_post_categories(),
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
                'options' => [
                    'AND' => esc_html__('AND', 'themename'),
                    'IN' => esc_html__('IN', 'themename'),
                    'NOT IN' => esc_html__('NOT IN', 'themename'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => esc_html__('Style', 'themename'),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_template_post_type(),
                'default' => 'post-style-1',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'themename'),
            ]
        );
        $this->register_thumbnail_controls();
        $this->register_title_controls();
        $this->register_category_controls();
        $this->register_excerpt_controls();
        $this->register_read_more_controls();
        $this->register_meta_controls();
        $this->end_controls_section();

        
        $this->register_design_image_controls();
        $this->register_design_content_controls();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }



    protected function register_thumbnail_controls()
    {
        $this->add_control(
            'advanced_image',
            [
                'label' => esc_html__('Image', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'default' => 'medium',
                'exclude' => [ 'custom' ],
                'prefix_class' => 'elementor-posts--thumbnail-size-',
            ]
        );
    }

    protected function register_title_controls()
    {
        $this->add_control(
            'advanced_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'yes',
                
            ]
        );

        $this->add_control(
            'post_title_tag',
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
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );
    }

    protected function register_category_controls()
    {
        $this->add_control(
            'advanced_category',
            [
                'label' => esc_html__('Category', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Category', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'yes',
            ]
        );
    }

    protected function register_excerpt_controls()
    {
        $this->add_control(
            'advanced_excerpt',
            [
                'label' => esc_html__('Excerpt', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Excerpt', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length', 'themename'),
                'type' => Controls_Manager::NUMBER,
                'default' => apply_filters('excerpt_length', 25),
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );
    }

    protected function register_read_more_controls()
    {
        $this->add_control(
            'advanced_read_more',
            [
                'label' => esc_html__('Read More', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Read More', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read more', 'themename'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );
    }

    protected function register_meta_controls()
    {
        $this->add_control(
            'advanced_meta',
            [
                'label' => esc_html__('Meta', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => esc_html__('Author', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'no',
            ]
        );
       


        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Date', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_comments',
            [
                'label' => esc_html__('Comments', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_comments_text',
            [
                'label' => esc_html__('Comments Text', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themename'),
                'label_off' => esc_html__('Hide', 'themename'),
                'default' => 'no',
                'condition' => [
                    'show_comments' => 'yes'
                ]
            ]
        );
    }

    public static function get_query_args($settings)
    {
        $query_args = [
            'post_type'           => 'post',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'suppress_filters'    => true,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];

        if (!empty($settings['categories'])) {
            $categories = array();
            foreach ($settings['categories'] as $category) {
                $cat = get_term_by('slug', $category, 'category');
                if (!is_wp_error($cat) && is_object($cat)) {
                    $categories[] = $cat->term_id;
                }
            }

            if ($settings['cat_operator'] == 'AND') {
                $query_args['category__and'] = $categories;
            } elseif ($settings['cat_operator'] == 'IN') {
                $query_args['category__in'] = $categories;
            } else {
                $query_args['category__not_in'] = $categories;
            }
        }

        $query_args['posts_per_page'] = $settings['limit'];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function query_posts()
    {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }


    protected function get_post_categories()
    {
        $categories = get_terms(
            array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    protected function register_design_image_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Image', 'themename'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_border_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('thumbnail_effects_tabs');

        $this->start_controls_tab(
            'normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_filters',
                'selector' => '{{WRAPPER}} .entry-thumb img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_hover_filters',
                'selector' => '{{WRAPPER}} .entry-thumb:hover .entry-thumb img',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_design_content_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'themename'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title_style',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_title_alignment',
            [
                'label'   => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .post .entry-title' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post .entry-title, {{WRAPPER}} .post .entry-title a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .post .entry-title, {{WRAPPER}} .post .entry-title a',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'post_title_spacing',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_category_style',
            [
                'label' => esc_html__('Category', 'themename'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_category_alignment',
            [
                'label'   => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'condition' => [
                    'show_category' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .post .entry-category' => 'justify-content: {{VALUE}} !important;',
                ],
            ]
        );


        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post .entry-category, {{WRAPPER}} .post .entry-category a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .post .entry-category, {{WRAPPER}} .post .entry-category a',
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'category_spacing',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post .entry-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_meta_style',
            [
                'label' => esc_html__('Meta', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        
        $this->add_responsive_control(
            'post_meta_alignment',
            [
                'label'   => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .post .entry-meta-list' => 'justify-content: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-meta-list, {{WRAPPER}} .entry-meta-list a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .entry-meta-list, {{WRAPPER}} .entry-meta-list a',
            ]
        );

        $this->add_control(
            'meta_spacing',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .entry-meta-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_excerpt_style',
            [
                'label' => esc_html__('Excerpt', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                   'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_excerpt_alignment',
            [
                'label'   => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'condition' => [
                    'show_excerpt' => 'yes',
                 ],
                'selectors'  => [
                    '{{WRAPPER}} .post .entry-description' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-description' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .entry-description',
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_spacing',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .entry-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_readmore_style',
            [
                'label' => esc_html__('Read More', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_readmore_alignment',
            [
                'label'   => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'condition' => [
                    'show_read_more' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .post .more' => 'text-align: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .readmore' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .readmore',
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_more_spacing',
            [
                'label' => esc_html__('Spacing', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .readmore' => 'margin-bottom: {{SIZE}}{{UNIT}}; display: block;',
                ],
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }


    private function get_template_post_type()
    {
        $folderes = glob(THEMENAME_PAGE_TEMPLATES. '/posts/item-*');
 
        $output = array();

        foreach ($folderes as $folder) {
            $folder = str_replace("item-", '', str_replace('.php', '', wp_basename($folder)));
            $value = str_replace('_', ' ', str_replace('-', ' ', ucfirst($folder)));
            $output[$folder] = $value;
        }

        return $output;
    }
}
$widgets_manager->register(new Themename_Elementor_Posts_Grid());
