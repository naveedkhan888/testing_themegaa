<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Product_Tabs')) {
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
class Lasa_Elementor_Product_Tabs extends Lasa_Elementor_Carousel_Base
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
        return 'tbay-product-tabs';
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
        return esc_html__('Lasa Product Tabs', 'lasa');
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
    public function get_script_depends()
    {
        return ['slick', 'lasa-custom-slick'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'tabs' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Product Tabs', 'lasa'),
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products ( -1 = all )', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min'  => -1
            ]
        );
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'lasa'),
                    'carousel'  => esc_html__('Carousel', 'lasa'),
                ],
            ]
        );
        $this->register_woocommerce_categories_operator();
        $this->add_control(
            'product_style',
            [
                'label' => esc_html__('Product Style', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inner',
                'options' => $this->get_template_product(),
                'prefix_class' => 'elementor-product-'
            ]
        );

        $this->add_control(
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Product Tabs', 'lasa' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__( 'Show/hidden Ajax Product Tabs', 'lasa' ), 
            ]
        );

        $this->register_controls_product_tabs();
        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'lasa'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
            ]
        );
        
        $this->end_controls_section();
        $this->register_style_product_item();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_style_heading();
    }

    public function register_controls_product_tabs()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'product_tabs_title',
            [
                'label' => esc_html__('Title', 'lasa'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'product_tabs',
            [
                'label' => esc_html__('Show Tabs', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest',
            ]
        );
        $this->add_control(
            'list_product_tabs',
            [
                'label' => esc_html__('Tab Item', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ product_tabs_title }}}',
            ]
        );
    }
    protected function register_style_heading()
    {
        $this->start_controls_section(
            'section_style_heading_categories_tab',
            [
                'label' => esc_html__('Heading Product Categories Tabs', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'style_heading_tab',
            [
                'label' => esc_html__('Style Heading Tab', 'lasa'),
                'description' => esc_html__('Only working on screen > 992px', 'lasa'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    'style-inline' => esc_html__('Inline', 'lasa'),
                    'style-block' => esc_html__('Block', 'lasa'),
                ],
                'default' => 'style-block',
                'prefix_class' => 'heading-tab-'
            ]
        );
        $this->add_responsive_control(
            'heading_categories_tab_align',
            [
                'label' => esc_html__('Alignment', 'lasa'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'style_heading_tab' => 'style-block'
                ],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'lasa'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lasa'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'lasa'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-product-tabs > .wrapper-heading-tab > ul, {{WRAPPER}} .tbay-element-product-tabs .heading-tbay-title' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
     
        $this->add_responsive_control(
            'heading_categories_tab_padding',
            [
                'label'      => esc_html__('Padding', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '13',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wrapper-heading-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_categories_tab_margin',
            [
                'label'      => esc_html__('Margin', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '35',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wrapper-heading-tab' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_heading_categories_tab',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .wrapper-heading-tab',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'heading_tab_title',
            [
                'label' => esc_html__('Tab Title', 'lasa'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'style_tab_title_typography',
                'selector' => '{{WRAPPER}} .tabs-list li a',
            ]
        ); 

        $this->start_controls_tabs('heading_tab_title_tabs');

        $this->start_controls_tab(
            'heading_tab_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'heading_tab_title_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tabs-list li a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_tab_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'heading_tab_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tabs-list li a.active,
                    {{WRAPPER}} .tabs-list li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label'      => esc_html__('Padding', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'separator'    => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .tabs-list li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label'      => esc_html__('Margin', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tabs-list li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_tab_border_active',
            [
                'label' => esc_html__('Border Tab Active', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'heading_tab_border_active_color',
            [
                'label' => esc_html__( 'Background Color', 'lasa' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-product-tabs .tabs-list > li > a.active:after,
                    {{WRAPPER}} .tbay-element-product-tabs .tabs-list > li > a:hover:after' => 'background: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_control(
            'heading_tab_border_active_height',
            [
                'label'     => esc_html__('Height', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabs-list > li > a:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_tab_border_active_position_bottom',
            [
                'label'     => esc_html__('Position Bottom', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabs-list > li > a:after' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_tab_border_active_position_left',
            [
                'label'     => esc_html__('Position Left', 'lasa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabs-list > li > a:after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    public function get_template_product()
    {
        return apply_filters('lasa_get_template_product', 'v1');
    }

    public function render_product_tabs($product_tabs, $key_id, $random_id, $title, $active)
    {
        ?>
            <li>
                <a href="javascript:void(0)"  data-bs-toggle="pill" data-bs-target="#<?php echo esc_attr($product_tabs.'-'.$random_id .'-'.$key_id); ?>" data-value="<?php echo esc_attr($product_tabs); ?>" class="<?php echo esc_attr($active); ?>"><?php echo trim($title)?></a>
            </li>

       <?php
    }

    public function render_product_tabs_content($list_product_tabs, $random_id)
    {   
        $settings = $this->get_settings_for_display();
        ?>
        <div class="tbay-addon-content tab-content woocommerce">
            <?php $_count = 0;?>
            <?php foreach ($list_product_tabs as $key) {
                    $tab_active = ($_count==0)? 'active active-content current':'';
                    $product_tabs = $key['product_tabs'];
                    ?>
                    <div class="tab-pane <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($product_tabs.'-'.$random_id .'-'.$key['_id']); ?>">
                    <?php
                    if( $_count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                        $this->render_content_tab($product_tabs);
                    }
                    $_count++; 
                    ?>
                    </div>
                    <?php
                }
            ?>
        </div>
        <?php
    }

    public function render_content_tab($product_tabs)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if (isset($rows) && !empty($rows)) {
            $this->add_render_attribute('row', 'class', 'row-'. $rows);
        }

        $product_type = $product_tabs;

        /** Get Query Products */
        $loop = lasa_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);
        
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row'); ?> 

        <?php wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row)); ?>

        <?php
    }
}
$widgets_manager->register(new Lasa_Elementor_Product_Tabs());
