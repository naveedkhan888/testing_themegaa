<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Products')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Lasa_Elementor_Products extends Lasa_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-products';
    }

    public function get_title()
    {
        return esc_html__('Lasa Products', 'lasa');
    }

    public function get_categories()
    {
        return [ 'lasa-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-products';
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
        return ['slick', 'lasa-custom-slick'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'lasa'),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'lasa'),
                'default' => 6,
                'min'  => -1
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'lasa'),
                'type' => Controls_Manager::HEADING,
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

        $this->register_woocommerce_order();

        $this->register_woocommerce_categories_operator();

        $this->add_control(
            'product_type',
            [
                'label' => esc_html__('Product Type', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $this->get_product_type(),
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
    }

    protected function register_button()
    {
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'lasa'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
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
                'label'     => esc_html__('Text Button', 'lasa'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('View all products', 'lasa'),
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Button', 'lasa'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
                    'library' => 'tbay-custom',
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
            <div class="readmore-wrapper"><a href="<?php echo esc_url($url_category)?>" class="show-all"><span><?php echo trim($text_show_all) ?></span>
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
                            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">
                                <?php if (!empty($heading_title)) : ?>
                                    <span class="title"><?php echo trim($heading_title); ?></span>
                                <?php endif; ?>	    	
                                <?php if (!empty($heading_subtitle)) : ?>
                                    <span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
                                <?php endif; ?>
                            </<?php echo trim($heading_title_tag); ?>>
                        <?php endif;
                
            if ($check_show_all_top) {
                ?> <div class="readmore-wrapper"><a href="<?php echo esc_url($url_show_all); ?>" class="show-all"><span><?php echo trim($settings['text_show_all']); ?></span>
                                <?php if (!empty($settings['icon_show_all']['value'])) {
                    echo '<i class="'. esc_attr($settings['icon_show_all']['value']) .'"></i>';
                } ?>
                            </a></div> <?php
            } ?>
                </div>
            <?php
        }
    }
}
$widgets_manager->register(new Lasa_Elementor_Products());
