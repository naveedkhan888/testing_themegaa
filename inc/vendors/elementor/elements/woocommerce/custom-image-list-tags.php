<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Custom_Image_List_Tags')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Custom_Image_List_Tags extends Themename_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'xptheme-custom-image-list-tags';
    }

    public function get_title()
    {
        return esc_html__('Themename Custom Image List Tags', 'themename');
    }

    public function get_script_depends()
    {
        return [ 'themename-custom-slick', 'slick' ];
    }

    public function get_categories()
    {
        return [ 'themename-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-tags';
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'custom-image-list-tags' ];
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

        $tag_slug = $this->get_woocommerce_tags();
        $repeater = new \Elementor\Repeater();

        if (is_array($tag_slug) && count($tag_slug)) {
            $tag_default = key($tag_slug);
            $repeater->add_control(
                'tag_slug',
                [
                    'label'     => esc_html__('Tag', 'themename'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $tag_slug,
                    'default'   => $tag_default
                ]
            );
        } else {
            $repeater->add_control(
                'tag_slug',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no tags in your site.</strong><br>Go to the <a href="%s" target="_blank">Tags screen</a> to create one.', 'themename'), admin_url('edit-tags.php?taxonomy=product_tag&post_type=product')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $repeater->add_control(
            'tag_style',
            [
                'label' => esc_html__('Choose Style', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'images' => [
                        'title' => esc_html__('Image', 'themename'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'themename'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default' => 'images',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'themename'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition'   => [
                    'tag_style' => 'images',
                ]
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label'       => esc_html__('Icon Button', 'themename'),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'default'     => [
                    'value'   => 'fas fa-info',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'tag_style'   => 'icon',
                ]
            ]
        );

        $repeater->add_control(
            'tag_add_link',
            [
                'label' => esc_html__('Add Custom Link', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'tag_custom_link',
            [
                'label'         => esc_html__('Link to', 'themename'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__('https://your-link.com', 'themename'),
                'condition'     => [
                    'tag_add_link'  => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tags',
            [
                'label' => esc_html__('List Tags', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->register_button();
        $this->end_controls_section();

        $this->register_design_content_controls();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_button()
    {
        $this->add_control(
            'show_before_text',
            [
                'label'     => esc_html__('Show Before Text', 'themename'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
                'prefix_class' => 'before-text-'
            ]
        );
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Button Show All', 'themename'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'themename'),
                'default'   => esc_html__('View all products', 'themename'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'icon_button',
            [
                'label'     => esc_html__('Icon Button', 'themename'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'xp-icon xp-icon-arrow-right',
                    'library' => 'xptheme-custom',
                ],
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label'     => esc_html__('Show Count', 'themename'),
                'description' => esc_html__('Display the product number of the tags', 'themename'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
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
        $this->add_responsive_control(
            'size',
            [
                'label' => esc_html__('Font Size Icon', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tag-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tag_name_typography',
                'selector' => '{{WRAPPER}} .custom-image-list-tags .tag-name',
            ]
        );

        $this->add_responsive_control(
            'align_content',
            [
                'label' => esc_html__('Alignment Tag Icon', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .item-tag.tag-icon' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_content_img',
            [
                'label' => esc_html__('Alignment Tag Image', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .item-tag.tag-img .content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .custom-image-list-tags .item-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_item_padding',
            [
                'label' => esc_html__('Icon Item Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .custom-image-list-tags .tag-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }
    public function render_item($item)
    {
        extract($item);
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $layout = 'v1';

        $tag   = get_term_by('slug', $tag_slug, 'product_tag');

        if (!is_object($tag)) {
            return;
        }

        $tag_name       = $tag->name;
        $tag_count      = themename_get_product_count_of_tags($tag);
        $count_item     = $show_count;

        /*Array tab*/
        $tab = [];
        $tab['images'] = $image['id'];
        $tab['shop_now'] = '';
        $tab['shop_now_text'] = '';
        $iconClass = '';


        if ($tag_style === 'icon') {
            $iconClass = $icon['value'];
            $tab['images'] = '';
        }

        if ($tag_add_link === 'yes') {
            $tag_link       =   $tag_custom_link['url'];
        } else {
            $tag_link       =   get_term_link($tag_slug, 'product_tag');
        } ?> 
    
        <?php wc_get_template('item-tag/tag-custom-'.$layout.'.php', array('tab'=> $tab,  'tag_link' => $tag_link, 'tag_name' => $tag_name ,'tag_count' => $tag_count ,'count_item' => $count_item , 'iconClass'=> $iconClass )); ?>

        <?php
    }
    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if ($show_all === 'yes') {
            $url =  get_permalink(wc_get_page_id('shop'));
            if (isset($text_button) && !empty($text_button)) {?>
                <div class="readmore-wrapper"><a href="<?php echo esc_url($url)?>" class="show-all"><span><?php echo trim($text_button) ?></span>
                    <?php
                        $this->render_item_icon($icon_button);
                    ?>
                    
                </a></div>
                <?php
            }
        }
    }
}
$widgets_manager->register(new Themename_Elementor_Custom_Image_List_Tags());
