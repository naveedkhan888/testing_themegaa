<?php
if (! defined('ABSPATH') || function_exists('Themename_Elementor_Product_Recently_Viewed_Header')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Product_Recently_Viewed_Header extends Themename_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-product-recently-viewed-header';
    }

    
    protected function get_html_wrapper_class()
    {
        return parent::get_html_wrapper_class() . ' w-auto ' . parent::get_name();
    }

    public function get_title()
    {
        return esc_html__('Themename Product Recently Viewed Header', 'themename');
    }

    public function get_categories()
    {
        return [ 'themename-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-clock';
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

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'Recently Viewed', 'Recently' ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );

        $this->register_control_header();

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'empty',
            [
                'label' => esc_html__('Empty Result - Custom Paragraph', 'themename'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('You have no recently viewed item.', 'themename'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );
        
        $this->add_control(
            'align_empty',
            [
                'label' => esc_html__('Align Empty Result', 'themename'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'themename'),
                    'center' => esc_html__('Center', 'themename'),
                    'right' => esc_html__('Right', 'themename')
                ],
                'default' => 'center',
                'dynamic' => [
                    'active' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-empty' => 'text-align: {{VALUE}};',
                ]
            ]
        );


        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        $this->register_control_style_header_title();
        $this->register_control_style_header_icon();
        $this->register_control_viewall();
    }

    private function register_control_viewall()
    {
        $this->start_controls_section(
            'section_readmore',
            [
                'label' => esc_html__('Read More Options', 'themename'),
                'type'  => Controls_Manager::SECTION,
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Button "Read More" Custom Text', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'themename'),
                'label_block' => true,
            ]
        );

        $pages = $this->get_available_pages();

        if (!empty($pages)) {
            $this->add_control(
                'readmore_page',
                [
                    'label'        => esc_html__('Page', 'themename'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $pages,
                    'default'      => array_keys($pages)[0],
                    'save_default' => true,
                    'label_block' => true,
                    'separator'    => 'after',
                ]
            );
        } else {
            $this->add_control(
                'readmore_page',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no pages in your site.</strong><br>Go to the <a href="%s" target="_blank">pages screen</a> to create one.', 'themename'), admin_url('edit.php?post_type=page')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->end_controls_section();
    }

    protected function register_control_style_header_icon() {
        $this->start_controls_section(
            'section_style_icon_header', 
            [
                'label' => esc_html__('Icon', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_recently_viewed_size',
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
                    '{{WRAPPER}} .header-title i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_icon_recently',
            [
                'label'     => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .header-title i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'padding_icon_recently',
            [
                'label'     => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .header-title i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_style_icon_recently');

        $this->start_controls_tab(
            'tab_icon_recently_normal',
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
                    '{{WRAPPER}} .header-title i'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_recently_hover',
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
                    '{{WRAPPER}} .header-title i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_control_style_header_title()
    {
        $this->start_controls_section(
            'section_style_heading_header',
            [
                'label' => esc_html__('Heading', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_header_typography',
                'selector' => '{{WRAPPER}} .product-recently-viewed-header h3',
            ]
        );

        $this->add_responsive_control(
            'heading_header_style_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_header_style_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('heading_header_tabs');

        $this->start_controls_tab(
            'heading_header_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'heading_header_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_header_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header h3' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_header_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'heading_header_color_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header:hover h3,
                    {{WRAPPER}} .product-recently-viewed-header:hover h3:after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_header_bg_hover',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .product-recently-viewed-header:hover h3' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    private function register_control_header()
    {
        $this->add_control(
            'advanced_header',
            [
                'label' => esc_html__('Header', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_recently_viewed',
            [
                'label'              => esc_html__('Icon', 'themename'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-recently-viewed',
                    'library' => 'tbay-custom',
                ],
            ]
        );


        $this->add_control(
            'show_title_recently_viewed',
            [
                'label'              => esc_html__('Display Title', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );

        $this->add_control(
            'header_title',
            [
                'label' => esc_html__('Title', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Recently Viewed', 'themename'),
                'label_block' => true,
                'condition' => [
                    'show_title_recently_viewed' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'header_column',
            [
                'label'     => esc_html__('Columns and max item', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 8,
                'separator'    => 'after',
                'options'   => $this->get_max_columns(),
            ]
        );
    }

    public function get_max_columns()
    {
        $value = apply_filters('themename_admin_elementor_recently_viewed_header_columns', [
           4 => 4,
           5 => 5,
           6 => 6,
           7 => 7,
           8 => 8,
           9 => 9,
           10 => 10,
           11 => 11,
           12 => 12,
        ]);

        return $value;
    }

    private function get_recently_viewed($limit)
    {
        $args = themename_tbay_get_products_recently_viewed($limit);
        $args = apply_filters('themename_list_recently_viewed_products_args', $args);

        $products = new WP_Query($args);

        ob_start(); ?>
            <?php while ($products->have_posts()) : $products->the_post(); ?>

                <?php wc_get_template_part('content', 'recent-viewed'); ?>

            <?php endwhile; // end of the loop.?>

        <?php

        $content = ob_get_clean();

        wp_reset_postdata();

        return $content;
    }

    public function render_content_main()
    {
        $header_title = $class = '';

        $settings = $this->get_settings_for_display();
        extract($settings);

        $products_list      = themename_tbay_wc_track_user_get_cookie();

        if ( !empty($products_list) ) {
            $content                    =  $this->get_recently_viewed($header_column);
            $class                      =  '';      
        } else {
            $content = $empty;
            $class   = 'empty';
        }


        $this->add_render_attribute('wrapper', 'data-column', $header_column); ?>

        <h3 class="header-title">
            <?php  
                $this->render_item_icon($icon_recently_viewed);
                echo esc_html($header_title); 
            ?>
        </h3>
        <div class="content-view <?php echo esc_attr($class); ?>">
            <div class="content-child">
                <div class="container">
                    <div class="list-recent">
                        <?php echo trim($content); ?>
                    </div>

                    <?php $this->render_btn_readmore($header_column); ?>
                </div>
            </div>
        </div>

        <?php
    }

    private function render_btn_readmore($count)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $products_list              =  themename_tbay_wc_track_user_get_cookie();
        $all                        =  count($products_list);

        if (!empty($readmore_page)) {
            $link = get_permalink($readmore_page);
        }

        if ($enable_readmore && ($all > $count) && !empty($link)) : ?>
            <a class="btn-readmore" href="<?php echo esc_url($link); ?>" title="<?php esc_attr($readmore_text); ?>"><?php echo trim($readmore_text); ?></a>
        <?php endif;
    }
}
$widgets_manager->register(new Themename_Elementor_Product_Recently_Viewed_Header());
