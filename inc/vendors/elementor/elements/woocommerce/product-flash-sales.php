<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Product_Flash_Sales')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Product_Flash_Sales extends Themename_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-product-flash-sales';
    }

    public function get_title()
    {
        return esc_html__('Themename Product Flash Sales', 'themename');
    }

    public function get_categories()
    {
        return [ 'themename-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-flash';
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
        return ['slick', 'themename-custom-slick', 'jquery-countdowntimer'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'Flash Sales', 'Flash' ];
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

        $this->register_control_main();
        
        $this->end_controls_section();
        
        $this->register_style_heading();
        $this->register_control_viewall();
        $this->register_style_product_item();
        $this->add_control_responsive();

        $this->add_control_carousel(['layout_type' => 'carousel']);
    }
    private function register_control_main()
    {
        $this->add_control(
            'main_advanced',
            [
                'label' => esc_html__('Main', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'date_title',
            [
                'label' => esc_html__('Title Date', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Ends in: ', 'themename'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'date_title_ended',
            [
                'label' => esc_html__('Title deal ended', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Deal ended.', 'themename'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'end_date',
            [
                'label' => esc_html__('End Date', 'themename'),
                'type' => Controls_Manager::DATE_TIME,
                'label_block' => true,
                'placeholder' => esc_html__('Choose the end time', 'themename'),
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
            'product_style',
            [
                'label' => esc_html__('Product Style', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inner',
                'options' => $this->get_template_product(),
                'prefix_class' => 'elementor-product-',
            ]
        );

        $list_campaigns = $this->get_list_campaigns();

        if (!empty($list_campaigns)) {
            $this->add_control(
                'sale_campaign',
                [
                    'label'     => esc_html__('Select campaign', 'themename'),
                    'type'      => Controls_Manager::SELECT2,
                    'options'   => $list_campaigns,
                    'default'   => array_keys($list_campaigns)[0],
                ]
            );

            $this->add_control(
                'limit',
                [
                    'label' => esc_html__('Number of products', 'themename'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('Number of products to show ( -1 = all )', 'themename'),
                    'default' => -1,
                    'min'  => -1,
                ]
            );
        } else {
            $this->add_control(
                'sale_html_campaign',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('You don not have any campaigns. <br>Go to the <strong><a href="%s" target="_blank">Discount Campaign screen</a></strong> to create one.', 'themename'), admin_url('edit.php?post_type=tb_discount_campaign')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
    }

    private function register_style_heading()
    {
        $this->start_controls_section(
            'section_style_heading_fl',
            [
                'label' => esc_html__('Style Heading Flash Sale', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enable_heading_fl_align_vertical_center',
            [
                'label' => esc_html__('Enable Alignment Center', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'heading-align-center-',
            ]
        );

        
        $this->add_responsive_control(
            'heading_fl_text_align',
            [
                'label' => esc_html__('Justify Content', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'themename'),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('center', 'themename'),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'themename'),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'themename'),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Around', 'themename'),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Evenly', 'themename'),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ], 
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'justify-content: {{VALUE}}',
                ],
            ]
        ); 

        $this->add_control(
            'heading_fl_bg',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_fl_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '4',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_fl_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '24',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_heading_categories_tab',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .top-flash-sale-wrapper',
            ]
        );

        $this->add_control(
            'heading_timer',
            [
                'label' => esc_html__('Timer', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'   => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'timer_typography',
                'selector' => '{{WRAPPER}} .times span:not(.label)',
            ]
        );

        $this->add_control(
            'timer_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .times > div' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'timer_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .times span:not(.label)' => 'color: {{VALUE}} !important;',
                ],
            ]
        );


        $this->add_control(
            'heading_label_timer',
            [
                'label' => esc_html__('Label timer', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'   => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_timer_typography',
                'selector' => '{{WRAPPER}} .times span.label',
            ]
        );

        $this->add_control(
            'label_timer_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .times span.label' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
 

        $this->end_controls_section();
    }

    protected function register_control_viewall()
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
            'readmore_position',
            [
                'label'     => esc_html__('Position', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'bottom',
                'options'   => [
                    'top'      => esc_html__('Top', 'themename'),
                    'bottom'  => esc_html__('Bottom', 'themename'),
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
                    'label_block' => true,
                    'save_default' => true,
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

    public function render_btn_readmore()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($readmore_page)) {
            $link = get_permalink($readmore_page);
        }

        if ($enable_readmore && !empty($link)) : ?>
            <div class="readmore-wrapper"><a class="show-all" href="<?php echo esc_url($link); ?>" title="<?php esc_attr($readmore_text); ?>"><span><?php echo trim($readmore_text); ?></span><i class="tb-icon tb-icon-arrow-right"></i></a></div>
        <?php endif;
    }

    public function render_content_main()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $ids = $this->get_id_products_flash_sale($sale_campaign);


        if (count($ids) === 0) {
            echo '<div class="not-product-flash-sales">'. esc_html__('Please select display campaign', 'themename')  .'</div>';
            return;
        }
        
        $args = array(
            'post_type'            => 'product',
            'ignore_sticky_posts'  => 1,
            'no_found_rows'        => 1,
            'posts_per_page'       => $limit,
            'orderby'              => 'post__in',
            'post__in'             => $ids,
        );

        if (version_compare(WC()->version, '2.7.0', '<')) {
            $args[ 'meta_query' ]   = isset($args[ 'meta_query' ]) ? $args[ 'meta_query' ] : array();
            $args[ 'meta_query' ][] = WC()->query->visibility_meta_query();
        } elseif (taxonomy_exists('product_visibility')) {
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $args[ 'tax_query' ]         = isset($args[ 'tax_query' ]) ? $args[ 'tax_query' ] : array();
            $args[ 'tax_query' ][]       = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids[ 'exclude-from-search' ] : $product_visibility_term_ids[ 'exclude-from-catalog' ],
                'operator' => 'NOT IN',
            );
        }

        $loop = new WP_Query($args);

        $end_date     = strtotime($end_date);
        if (!$loop->have_posts()) {
            return;
        }

        
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');
        
        wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'flash_sales' => true, 'end_date' => $end_date, 'attr_row' => $attr_row));
        
        if( $readmore_position === 'bottom' ) {
            $this->render_btn_readmore();
        }
    }
    public function deal_end_class()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);


        $class_deal_ended   = '';
        $end_date           = strtotime($end_date);
        $today              = strtotime("today");
        if (!empty($end_date) &&  ($today > $end_date)) {
            $class_deal_ended = 'deal-ended';
        }

        return $class_deal_ended;
    }

    protected function get_id_products_flash_sale($sale_campaign)
    {
        $product_ids = array();

        if( empty($sale_campaign) ) return $product_ids;

        $sale_products = get_post_meta($sale_campaign, 'tbay_discount_campaign_group', true);

        if( empty($sale_products) || sizeof($sale_products) === 0 ) return $product_ids;

        foreach ($sale_products as $item) :

            extract($item);

            array_push($product_ids, $product_sale_item);

        endforeach;

        return $product_ids;
    }
}
$widgets_manager->register(new Themename_Elementor_Product_Flash_Sales());
