<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_List_Categories_Product')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Lasa_Elementor_List_Categories_Product extends Lasa_Elementor_Carousel_Base
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
        return 'tbay-list-categories-product';
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
        return esc_html__('Lasa List Categories Product', 'lasa');
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
        return [ 'woocommerce-elements', 'list-categories-product' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('List Categories Product', 'lasa'),
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of categories', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of categories to show ( -1 = all )', 'lasa'),
                'min'  => -1,
                'default' => 6,
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Count', 'lasa'),
                'type' => Controls_Manager::SWITCHER,
                
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
                'type'      => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'no' => esc_html__('No', 'lasa'),
                    'show' => esc_html__('Show All', 'lasa')
                ]
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'lasa'),
                'default'   => esc_html__('View all products', 'lasa'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_all' => 'show'
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
                    'show_all' => 'show'
                ]
            ]
        );
    }
    
    public function render_list_category()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $array = $this->get_product_categories($limit);
        
        $this->add_render_attribute('item', 'class', 'item');
        foreach ($array as $key => $value) {
            ?>
                <div <?php $this->print_render_attribute_string('item'); ?> >
                    <div class="item-cat">
                        <?php
                            $obj_cat = get_term_by('slug', $key, 'product_cat');

                            
                            if ( is_object($obj_cat) ) :

                                $name  = $obj_cat->name;
                                $count = $obj_cat->count;
                                $url_category =  get_term_link($obj_cat);

                                $term_id = $obj_cat ->term_id;
                                $thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
                                $image        = wp_get_attachment_url($thumbnail_id);


                                                

                                if (!empty($image) && isset($image)) {
                                    ?>
                                                        <a href="<?php echo esc_url($url_category) ?>">
                                                            <?php echo '<img src="'. esc_url($image) .'" alt="'. esc_attr($name) .'" />'; ?>
                                                        </a>
                                                        
                                                    <?php
                                }

                                echo '<div class="cat-content">'; ?>
                                        <a href="<?php echo esc_url($url_category) ?>" class="cat-name"><?php echo trim($name) ?></a>
                                        <?php
                                            if ($show_count === 'yes') {
                                                ?>
                                                <span class="count-item"><?php echo trim($count).' '.esc_html__('products', 'lasa'); ?></span>
                                                <?php
                                            } ?>
                                        
                                    <?php
                                
                                echo '</div>';

                            endif;
                            
                            ?>    
                            
                    </div>
                </div>

            <?php
        }
    }

    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $url_category =  get_permalink(wc_get_page_id('shop'));
        if (isset($text_button) && !empty($text_button)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="btn"><?php echo trim($text_button) ?>
                <?php
                    $this->render_item_icon($icon_button);
                ?>
                
            </a>
            <?php
        }
    }
}
$widgets_manager->register(new Lasa_Elementor_List_Categories_Product());
