<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Product_CountDown')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Themename_Elementor_Product_CountDown extends Themename_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'xptheme-product-count-down';
    }

    public function get_title()
    {
        return esc_html__('Themename Product CountDown', 'themename');
    }

    public function get_categories()
    {
        return [ 'themename-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-countdown';
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
        return [ 'woocommerce-elements', 'product', 'products', 'countdown'];
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
            'countdown_title',
            [
                'label' => esc_html__('Title Date', 'themename'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Deal ends in:', 'themename'),
                'label_block' => true,
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
                'options' => $this->get_template_product_grid(),
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
                'main_html_campaign',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('You don not have any campaigns. <br>Go to the <strong><a href="%s" target="_blank">Discount Campaign screen</a></strong> to create one.', 'themename'), admin_url('edit.php?post_type=tb_discount_campaign')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }


        $this->register_button();

        $this->end_controls_section();
        $this->register_style_product_item();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_button()
    {
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'themename'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'position_show_all',
            [
                'label'     => esc_html__('Position', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    'top' => esc_html__('Top', 'themename'),
                    'bottom' => esc_html__('Bottom', 'themename'),
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
                'label'     => esc_html__('Text Button', 'themename'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('View all products', 'themename'),
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Button', 'themename'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
                    'library' => 'xptheme-custom',
                ],
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
    }

    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $url_category =  get_permalink(wc_get_page_id('shop'));
        if (isset($text_show_all) && !empty($text_show_all)) {?>
            <div class="readmore-wrapper"><a href="<?php echo esc_url($url_category); ?>" class="show-all"><span><?php echo trim($text_show_all); ?></span>
                <?php
                    $this->render_item_icon($icon_show_all);
                ?>
            </a></div>
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
                            <<?php echo trim($heading_title_tag); ?> class="heading-xptheme-title">
                                <?php if (!empty($heading_title)) : ?>
                                    <span class="title"><?php echo trim($heading_title); ?></span>
                                <?php endif; ?>	    	
                                <?php if (!empty($heading_subtitle)) : ?>
                                    <span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
                                <?php endif; ?>
                            </<?php echo trim($heading_title_tag); ?>>
                        <?php endif;
                
            if ($check_show_all_top) {
                ?> <div class="readmore-wrapper"><a href="<?php echo esc_url($url_show_all) ?>" class="show-all"><span><?php echo trim($settings['text_show_all']); ?></span>
                                <?php if (!empty($settings['icon_show_all']['value'])) {
                    echo '<i class="'. esc_attr($settings['icon_show_all']['value']) .'"></i>';
                } ?>
                            </a></div> <?php
            } ?>
                </div>
            <?php
        }
    }
    public function render_content_product_count_down()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $ids = $this->get_id_products_countdown($sale_campaign);

        if (!is_array($ids)) {
            $atts['ids'] = $ids;
        } else {
            if (count($ids) === 0) {
                echo '<div class="not-product-count-down">'. esc_html__('Please select display campaign', 'themename')  .'</div>';
                return;
            }

            $atts['ids'] = implode(',', $ids);
        }

        $atts['orderby'] = 'post__in';
        $atts['posts_per_page'] = $limit;

        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();

        $loop = new WP_Query($args);

        if (!$loop->have_posts()) {
            return;
        }
        
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template('layout-products/layout-products.php', array( 'loop' => $loop, 'product_style' => $product_style, 'countdown_title' => $countdown_title, 'countdown' => true, 'attr_row' => $attr_row));
    }
    protected function get_id_products_countdown($sale_campaign)
    {
        $product_ids = array();

        if( empty($sale_campaign) ) return $product_ids;

        $sale_products = get_post_meta($sale_campaign, 'xptheme_discount_campaign_group', true);

        if( empty($sale_products) || sizeof($sale_products) === 0 ) return $product_ids;

        foreach ($sale_products as $item) :

            extract($item);
            array_push($product_ids, $product_sale_item);
 
        endforeach;

        return $product_ids;
    }
}
$widgets_manager->register(new Themename_Elementor_Product_CountDown());
