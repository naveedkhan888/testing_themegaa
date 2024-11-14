<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Themename_Elementor_Search_Popup') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Themename_Elementor_Search_Popup extends Themename_Elementor_Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'xptheme-search-popup'; 
    }

    public function get_title() {
        return esc_html__('Themename Search Popup', 'themename');
    }
    
    public function get_icon() {
        return 'eicon-search';
    }

    protected function get_html_wrapper_class() {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        ); 
        $this->_register_form_popup();
        $this->_register_button_search();
        $this->_register_category_search();

        $this->add_control(
            'advanced_show_result',
            [
                'label' => esc_html__('Show Result', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'show_image_search',
            [
                'label'   => esc_html__('Show Image of Search Result', 'themename'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_price_search',
            [
                'label'              => esc_html__('Show Price of Search Result', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'search_type' => 'product',
                ]
            ]
        );
        $this->add_control(
            'show_price_under_title',
            [
                'label'              => esc_html__('show price under title', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'prefix_class'      => 'price-under-title-',
                'default' => '',
            ]
        );
        $this->end_controls_section();
        $this->register_style_search_popup();
    }
    protected function _register_form_popup() {
        $this->add_control(
            'advanced_type_search',
            [
                'label' => esc_html__('Form', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label'              => esc_html__('Search Result', 'themename'),
                'type'               => Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'product'  => esc_html__('Product','themename'),
                    'post'  => esc_html__('Blog','themename')
                ]
            ]
        );

        
        $this->add_control(
            'autocomplete_search',
            [
                'label'              => esc_html__('Auto-complete Search', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => true,
            ]
        );
        $this->add_control(
            'placeholder_text',
            [
                'label'              => esc_html__('Placeholder Text', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('Search for products...','themename'),
            ]
        );
        $this->add_control(
            'vali_input_search',
            [
                'label'              => esc_html__('Text Validate Input Search', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('Enter at least 2 characters','themename'),
            ]
        );
        $this->add_control(
            'min_characters_search',
            [
                'label'              => esc_html__('Search Minimum Characters', 'themename'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
            ]
        );
        $this->add_control(
            'search_max_number_results',
            [
                'label'              => esc_html__('Max Number of Search Results', 'themename'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 10,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
            ]
        );

    }

    protected function _register_button_search() {
        $this->add_control(
            'advanced_button_search',
            [
                'label' => esc_html__('Button Search', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'text_button_search',
            [
                'label'              => esc_html__('Button Search Text', 'themename'),
                'type'               => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'icon_button_search',
            [
                'label'              => esc_html__('Button Search Icon', 'themename'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'icon-magnifier',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
       
    }

    protected function _register_category_search() {
        $this->add_control(
            'advanced_categories_search',
            [
                'label' => esc_html__('Categories Search', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'enable_categories_search',
            [
                'label'              => esc_html__('Enable Search in Categories', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'text_categories_search',
            [
                'label'              => esc_html__('Search in Categories Text', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('All Categories','themename'),
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'count_categories_search',
            [
                'label'              => esc_html__('Show count in Categories', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => true,
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
    }

    protected function register_style_search_popup() {
        $this->start_controls_section(
            'section_style_search_popup',
            [
                'label' => esc_html__('General', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_icon_search',
            [
                'label' => esc_html__( 'Icon', 'themename' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'icon_search_size',
            [
                'label' => esc_html__('Font Size', 'themename'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
				'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
			'border_radius_search',
			[
				'label' => esc_html__( 'Border Radius', 'themename' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn-search-icon > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'padding_search',
            [
                'label'     => esc_html__('Padding Icon Search', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );  
        
        $this->start_controls_tabs('tabs_style_icon_search');

        $this->start_controls_tab(
            'tab_icon_search_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'color_icon_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-search-icon > svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );   

        $this->add_control(
            'bg_icon_search',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
 

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_search_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'hover_color_icon_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i:hover'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-search-icon > svg:hover'      => 'fill: {{VALUE}}',
                ],
            ]
        ); 
       
        $this->add_control(
            'hover_bg_icon_search',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i:hover,
                    {{WRAPPER}} .btn-search-icon > svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__( 'Text', 'themename' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_search_size_typography',
                'selector' => '{{WRAPPER}} .btn-search-icon > .text',
            ]
        );




        $this->start_controls_tabs('tabs_style_text_search');

        $this->start_controls_tab(
            'tab_text_search_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'color_text_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > .text'    => 'color: {{VALUE}}',
                ],
            ]
        );   

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_search_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'hover_color_text_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > .text:hover'    => 'color: {{VALUE}}',
                ],
            ]
        ); 

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function get_script_depends() {
        return ['jquery-sumoselect', 'jquery-magnific-popup'];
    }
    public function get_style_depends() {
        return ['sumoselect', 'magnific-popup'];
    }
    
    public function render_search_popup() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = themename_xptheme_random_key();

        $class_active_ajax = themename_switcher_to_boolean($autocomplete_search) ? 'themename-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => themename_switcher_to_boolean($show_image_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => themename_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        ); 
        ?>
            <div id="xptheme-search-form-popup" class="xptheme-search-form">
                <button type="button" class="btn-search-icon search-open" data-mfp-src="#sidebar-popup-search">
                    <?php $this->render_item_icon($icon_button_search) ?>
                    <?php if(!empty($text_button_search) && isset($text_button_search) ) {
                        ?>
                            <span class="text"><?php echo trim($text_button_search); ?></span>
                        <?php
                    } ?>
                </button>
                <div id="sidebar-popup-search" class="sidebar-popup-search zoom-anim-dialog mfp-hide">
                    <div class="sidebar-content">
                        <div class="content-heading">
                            <h3 class="heading"><?php esc_html_e('Search', 'themename'); ?></h3>
                            <button type="button" class="btn-search-close">
                                <i class="tb-icon tb-icon-close-02"></i>
                            </button> 
                        </div>

                        <div class="xptheme-search-form">
                            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" <?php $this->print_render_attribute_string( 'search_form' ); ?> >
                                <div class="form-group">
                                    <div class="input-group">

                                    <?php if ( $enable_categories_search === 'yes' ): ?>
                                        <div class="select-category input-group-addon">
                                            <?php if ( class_exists( 'WooCommerce' ) && $search_type === 'product' ) :
                                                $args = array(
                                                    'show_option_none'   => $text_categories_search,
                                                    'show_count' => $count_categories_search,
                                                    'hierarchical' => true,
                                                    'id' => 'product-cat-'.$_id, 
                                                    'show_uncategorized' => 0
                                                );
                                            ?> 
                                            <?php wc_product_dropdown_categories( $args ); ?>
                                            
                                            <?php elseif ( $search_type === 'post' ):
                                                $args = array(
                                                    'show_option_all' => $text_categories_search,
                                                    'show_count' => $count_categories_search,
                                                    'hierarchical' => true,
                                                    'show_uncategorized' => 0,
                                                    'name' => 'category',
                                                    'id' => 'blog-cat-'.$_id,
                                                    'class' => 'postform dropdown_product_cat',
                                                );
                                            ?>
                                                <?php wp_dropdown_categories( $args ); ?>
                                            <?php endif; ?>
                                            <div class="select-category-border"></div>
                                        </div>
                                    <?php endif; ?>

                                    <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="xptheme-search form-control input-sm"/>

                                    <div class="button-group input-group-addon">
                                        <button type="submit" class="button-search btn btn-sm>">
                                            <?php $this->render_item_icon($icon_button_search) ?>
                                        </button>
                                        <div class="xptheme-search-clear"></div>
                                    </div>

                                    <div class="search-results-wrapper">
                                        <div class="themename-search-results search-results-<?php echo esc_attr( $_id );?>" ></div>
                                    </div>

                                        <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

}
$widgets_manager->register(new Themename_Elementor_Search_Popup());

