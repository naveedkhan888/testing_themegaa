<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Product_Categories_Tabs')) {
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
class Lasa_Elementor_Product_Categories_Tabs extends Lasa_Elementor_Carousel_Base
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
        return 'tbay-product-categories-tabs';
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
        return esc_html__('Lasa Product Categories Tabs', 'lasa');
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
        return 'eicon-product-tabs';
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
        return [ 'woocommerce-elements', 'product-categories' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Product Categories', 'lasa'),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'lasa'),
                'default' => 6,
                'min'  => -1,
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'lasa'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->register_woocommerce_order();
        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'lasa'),
                'type'     => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest'
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
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Categories Tabs', 'lasa' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__( 'Show/hidden Ajax Categories Tabs', 'lasa' ), 
            ]
        );

        $this->add_control(
            'icon_after_title',
            [
                'label' => esc_html__( 'Show Icon After Title', 'lasa' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__( 'Show/hidden Icon After Title', 'lasa' ), 
                'prefix_class' => 'icon-after-title-'
            ]
        );

        $repeater = $this->register_category_repeater();
        $this->add_control(
            'categories_tabs',
            [
                'label' => esc_html__('Categories Items', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'categories_field' => '{{{ categories }}}',
            ]
        );

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

        
        $this->register_button();
        $this->end_controls_section();
        $this->register_style_product_item();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_style_heading();
    }

    private function register_category_repeater()
    {
        $repeater = new \Elementor\Repeater();
        $categories = $this->get_product_categories();
        $repeater->add_control(
            'category',
            [
                'label' => esc_html__('Select Category', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'label_block' => true,
                'options'   => $categories,
            ]
        );

        return $repeater;
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
                    '{{WRAPPER}} .wrapper-heading-tab .tabs-list, {{WRAPPER}} .wrapper-heading-tab .heading-tbay-title' => 'justify-content: {{VALUE}};',
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
                    'bottom' => '12',
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
                    'bottom' => '6',
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
            ]
        );

        $this->add_control(
            'heading_tab_border_active_color',
            [
                'label' => esc_html__( 'Background Color', 'lasa' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-product-categories-tabs .tabs-list > li > a.active:after,
                    {{WRAPPER}} .tbay-element-product-categories-tabs .tabs-list > li > a:hover:after' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .tbay-element-product-categories-tabs .tabs-list > li > a:after' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .tbay-element-product-categories-tabs .tabs-list > li > a:after' => 'bottom: {{SIZE}}{{UNIT}};',
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
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-product-categories-tabs .tabs-list > li > a:after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }
    protected function register_button()
    {
        $this->add_control(
            'show_more',
            [
                'label'     => esc_html__('Display Show All', 'lasa'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'lasa'),
                'default'   => esc_html__('Show all', 'lasa'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_more' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_button',
            [
                'label'     => esc_html__('Icon Button', 'lasa'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
                    'library' => 'tbay-custom',
                ],
                'condition' => [
                    'show_more' => 'yes'
                ]
            ]
        );
    }
   

    public function get_template_product()
    {
        return apply_filters('lasa_get_template_product', 'inner');
    }

    public function render_tabs_title($categories_tabs, $random_id)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);


        if ($ajax_tabs === 'yes') {
            $this->add_render_attribute('row', 'class', ['products']);
            $attr_row = $this->get_render_attribute_string('row'); 
    
            $json = array(
                'product_type'          => $product_type,
                'cat_operator'          => '',
                'limit'                 => $limit,
                'orderby'               => $orderby,
                'order'                 => $order,
                'product_style'         => $product_style,
                'attr_row'              => $attr_row,
            ); 
    
            $encoded_settings  = wp_json_encode( $json );
            $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
        } else {
            $tabs_data = '';
        }
        ?>
            
            <?php
                if (!empty($title_cat_tab) || !empty($sub_title_cat_tab)) {
                    ?>
                    <h3 class="heading-tbay-title">
                        <?php if (!empty($title_cat_tab)) : ?>
                            <span class="title"><?php echo trim($title_cat_tab); ?></span>
                        <?php endif; ?>	    	
                        <?php if (!empty($sub_title_cat_tab)) : ?>
                            <span class="subtitle"><?php echo trim($sub_title_cat_tab); ?></span>
                        <?php endif; ?>
                    </h3>
                    <?php
                } ?>

            <ul class="product-categories-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
                <?php $_count = 0; ?>
                <?php foreach ($categories_tabs as $item) : ?>
                    <?php $this->render_product_tab($item['category'], $item['_id'], $_count, $random_id); ?>
                    <?php $_count++; ?>
                <?php endforeach; ?>
                
            </ul>
            
        <?php
    }
    public function render_product_tab($item, $_id, $_count, $random_id)
    {
        ?>
        <?php
        $active = ($_count == 0) ? 'active' : '';
        $obj_cat = get_term_by('slug', $item, 'product_cat');

        if ( !is_object($obj_cat) ) return;
        
        $title = $obj_cat->name; ?> 
        <li >  
            <a href="javascript:void(0)" data-bs-toggle="pill" data-bs-target="#<?php echo esc_attr($item.'-'. $random_id .'-'.$_id); ?>" class="<?php echo esc_attr($active); ?>" data-value="<?php echo esc_attr($item); ?>"><?php echo trim($title); ?></a>
        </li>

       <?php
    }
    public function render_product_tabs_content($categories_tabs, $random_id)
    {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="content-product-category-tab">
                <div class="tbay-addon-content tab-content woocommerce">
                 <?php
                    $_count = 0;
                    foreach ($categories_tabs as $key) {
                        if( is_object(get_term_by('slug', $key['category'], 'product_cat')) ) :

                            $tab_active = ($_count == 0) ? ' active active-content current' : ''; 
                            ?> 
                            <div class="tab-pane <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($key['category'].'-'. $random_id .'-'.$key['_id']); ?>"> 
                            <?php
                            if( $_count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                                $this->render_content_tab($key['category'], $tab_active, $key['_id'], $random_id);
                            }
                            $_count++; 
                            ?>
                            </div>
                            <?php

                        endif;
                    } 
                ?>
                </div>
            </div>
        <?php
    }
    private function render_content_tab($key, $tab_active, $_id, $random_id)
    {
        $settings = $this->get_settings_for_display();
        $cat_operator = $product_type = $limit = $orderby = $order = '';
        extract($settings);
        
        /** Get Query Products */
        $loop = lasa_get_query_products($key, $cat_operator, $product_type, $limit, $orderby, $order);

        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row'); ?>
        
        <?php wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row)); ?>
        <?php
    }
    
    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $url_category =  get_permalink(wc_get_page_id('shop'));
        if (isset($text_button) && !empty($text_button)) {?>
            <div class="readmore-wrapper"><a href="<?php echo esc_url($url_category)?>" class="btn show-all"><span><?php echo trim($text_button) ?></span>
                <?php
                    $this->render_item_icon($icon_button);
                ?>
            </a></div>
            <?php
        }
    }
}
$widgets_manager->register(new Lasa_Elementor_Product_Categories_Tabs());
