<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Search_Form')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;

class Themename_Elementor_Search_Form extends Themename_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'xptheme-search-form';
    }

    public function get_title()
    {
        return esc_html__('Themename Search Form', 'themename');
    }
    
    public function get_icon()
    {
        return 'eicon-search';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Search Form', 'themename'),
            ]
        );
       
        $this->_register_form_search();
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
            'show_subtitle_search',
            [
                'label'   => esc_html__('Show Subtitle of Search Result', 'themename'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $this->register_section_style_search_form();
    }

    protected function register_section_style_search_form()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Search Form', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'search_form_line_height',
            [
                'label' => esc_html__('Line Height', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search,
                    {{WRAPPER}} .xptheme-search-form .select-category,
                    {{WRAPPER}} .xptheme-search-form .select-category > select' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .xptheme-search-form .select-category,{{WRAPPER}} .xptheme-search-form .button-search:not(.icon),
                    {{WRAPPER}} .xptheme-search-clear,{{WRAPPER}} .xptheme-search-form .button-search:not(.icon) i,
                    {{WRAPPER}} .xptheme-search-form .SumoSelect, 
                    {{WRAPPER}} .xptheme-search-form .select-category .CaptionCont' => 'line-height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_control(
            'search_form_width',
            [
                'label' => esc_html__('Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                    ]
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group,
                    {{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'padding_xptheme_search_form',
            [
                'label'     => esc_html__('Padding Search Form', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_xptheme_search_form',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group'    => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'border_style_xptheme_search_form',
            [
                'label' => esc_html__('Border Type', 'themename'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'themename'),
                    'solid' => esc_html__('Solid', 'themename'),
                    'double' => esc_html__('Double', 'themename'),
                    'dotted' => esc_html__('Dotted', 'themename'),
                    'dashed' => esc_html__('Dashed', 'themename'),
                    'groove' => esc_html__('Groove', 'themename'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group' => 'border-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_width_xptheme_search_form',
            [
                'label' => esc_html__('Width', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],

                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .SumoSelect.open>.optWrapper,{{WRAPPER}} .autocomplete-suggestions' => 'margin-top: {{BOTTOM}}{{UNIT}};'
                ],
                'condition' => [
                    'border_style_xptheme_search_form!' => '',
                ],
            ]
        );
        $this->add_control(
            'border_color_xptheme_search_form',
            [
                'label' => esc_html__('Border Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_xptheme_search_form!' => '',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_xptheme_search_form',
            [
                'label'     => esc_html__('Border Radius Search Form', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ,'%'],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .form-group .input-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .xptheme-search-form .select-category .CaptionCont' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'advanced_categories_search_style',
            [
                'label' => esc_html__('Categories Search', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'bg_category_search',
            [
                'label'     => esc_html__('Background', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .select-category'    => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'color_category_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .select-category','{{WRAPPER}} .xptheme-search-form .select-category > select'    => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'padding_category_search',
            [
                'label'     => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .select-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_style_category_search',
            [
                'label' => esc_html__('Border Type', 'themename'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'themename'),
                    'solid' => esc_html__('Solid', 'themename'),
                    'double' => esc_html__('Double', 'themename'),
                    'dotted' => esc_html__('Dotted', 'themename'),
                    'dashed' => esc_html__('Dashed', 'themename'),
                    'groove' => esc_html__('Groove', 'themename'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .select-category' => 'border-style: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_xptheme_search_form' => '',
                    'enable_categories_search' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'border_width_category_search',
            [
                'label' => esc_html__('Width', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],

                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .select-category' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
                'condition' => [
                    'border_style_category_search!' => '',
                ],
            ]
        );
        $this->add_control(
            'border_color_category_search',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .select-category' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_category_search!' => '',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_category_search',
            [
                'label'     => esc_html__('Border Radius Search Form', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ,'%'],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .select-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
                'condition' => [
                    'border_style_category_search!' => '',
                ],
            ]
        );

        $this->add_control(
            'advanced_btn_search_style',
            [
                'label' => esc_html__('Button Search', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'padding_btn',
            [
                'label'     => esc_html__('Padding Button Search', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .button-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'margin_btn',
            [
                'label'     => esc_html__('Margin Button Search', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .button-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_btn_search',
            [
                'label'     => esc_html__('Border Radius Button Group Search', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ,'%'],
                'selectors'  => [ 
                    '{{WRAPPER}} .xptheme-search-form .button-group,
                    {{WRAPPER}} .xptheme-search-form .button-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    
                ],
            ]
        );
        
        $this->start_controls_tabs('tabs_style_btn_search');

        $this->start_controls_tab(
            'tab_btn_search_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        $this->add_control(
            'color_btn_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .button-search i,
                    {{WRAPPER}} .xptheme-search-form .button-search .text, {{WRAPPER}} .xptheme-search-form .button-group:before'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_btn_search',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .button-search,{{WRAPPER}} .xptheme-search-form .button-group'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_btn_search_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        $this->add_control(
            'hover_color_btn_search',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .button-search:hover i,
                    {{WRAPPER}} .xptheme-search-form .button-search:hover .text'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_btn_search',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .button-search:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
       
        $this->add_control(
            'advanced_input_search_style',
            [
                'label' => esc_html__('Input Search', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'bg_input',
            [
                'label'     => esc_html__('Background Input Search', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_input',
            [
                'label'     => esc_html__('Color Input Search', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .form-control::placeholder'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'border_style_input_search',
            [
                'label' => esc_html__('Border Type', 'themename'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'themename'),
                    'solid' => esc_html__('Solid', 'themename'),
                    'double' => esc_html__('Double', 'themename'),
                    'dotted' => esc_html__('Dotted', 'themename'),
                    'dashed' => esc_html__('Dashed', 'themename'),
                    'groove' => esc_html__('Groove', 'themename'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search' => 'border-style: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_xptheme_search_form' => '',
                ],
            ]
        );
        $this->add_control(
            'border_width_input_search',
            [
                'label' => esc_html__('Width', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],

                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
                'condition' => [
                    'border_style_input_search!' => '',
                ],
            ]
        );
        $this->add_control(
            'border_color_input_search',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_input_search!' => '',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_input_search',
            [
                'label'     => esc_html__('Border Radius Search Form', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ,'%'],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
                'condition' => [
                    'border_style_input_search!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_search_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-search-form .xptheme-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function _register_form_search()
    {
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
                    'product'  => esc_html__('Product', 'themename'),
                    'post'  => esc_html__('Blog', 'themename')
                ]
            ]
        );

        
        $this->add_control(
            'autocomplete_search',
            [
                'label'              => esc_html__('Auto-complete Search', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'placeholder_text',
            [
                'label'              => esc_html__('Placeholder Text', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Search products...', 'themename'),
            ]
        );
        $this->add_control(
            'vali_input_search',
            [
                'label'              => esc_html__('Text Validate Input Search', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Enter at least 2 characters', 'themename'),
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

    protected function _register_button_search()
    {
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
                'default' => '',
            ]
        );
        $this->add_control(
            'icon_button_search',
            [
                'label'              => esc_html__('Button Search Icon', 'themename'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'library' => 'xp-icon',
                    'value'   => 'xp-icon xp-icon-search'
                ],
            ]
        );
        $this->add_control(
            'icon_button_search_size',
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
                    '{{WRAPPER}} .button-search i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
    }

    protected function _register_category_search()
    {
        $this->add_control(
            'advanced_categories_search',
            [
                'label'         => esc_html__('Categories Search', 'themename'),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );
        $this->add_control(
            'enable_categories_search',
            [
                'label'              => esc_html__('Enable Search in Categories', 'themename'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control(
            'text_categories_search',
            [
                'label'              => esc_html__('Search in Categories Text', 'themename'),
                'type'               => Controls_Manager::TEXT,
                'default'            =>  esc_html__('All Categories', 'themename'),
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
                'default' => 'yes',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
    }
    public function get_script_depends()
    {
        return ['jquery-sumoselect'];
    }
    public function get_style_depends()
    {
        return ['sumoselect'];
    }
    

    public function render_search_form()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = themename_xptheme_random_key();
        $class_active_ajax = (themename_switcher_to_boolean($autocomplete_search)) ? 'themename-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => themename_switcher_to_boolean($show_image_search),
                'data-subtitle' => themename_switcher_to_boolean($show_subtitle_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => themename_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        ); ?>
            <div class="xptheme-search-form">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" <?php $this->print_render_attribute_string('search_form'); ?> >
                    <div class="form-group">
                        <div class="input-group">

                        <?php if ($enable_categories_search === 'yes'): ?>
                                <div class="select-category input-group-addon">
                                    <?php if (class_exists('WooCommerce') && $search_type === 'product') :
                                        $args = array(
                                            'show_option_none'   => $text_categories_search,
                                            'show_count' => themename_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'id' => 'product-cat-'.$_id,
                                            'show_uncategorized' => 0
                                        ); ?> 
                                    <?php wc_product_dropdown_categories($args); ?>
                                    
                                    <?php elseif ($search_type === 'post'):
                                        $args = array(
                                            'show_option_all' => $text_categories_search,
                                            'show_count' => themename_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'show_uncategorized' => 0,
                                            'name' => 'category',
                                            'id' => 'blog-cat-'.$_id,
                                            'class' => 'postform dropdown_product_cat',
                                        ); ?>
                                        <?php wp_dropdown_categories($args); ?>
                                    <?php endif; ?>

                                    <div class="select-category-border"></div>
                                </div>
                                
                                
                        <?php endif; ?>

                        
                        <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="xptheme-search form-control input-sm"/>
                        
                        <div class="search-results-wrapper">
                            <div class="themename-search-results search-results-<?php echo esc_attr($_id); ?>" ></div>
                        </div>

                        <div class="button-group input-group-addon">
                            <button type="submit" class="button-search btn btn-sm>">
                                <?php $this->render_item_icon($icon_button_search) ?>
                                <?php if (!empty($text_button_search) && isset($text_button_search)) {
                                    ?>
                                        <span class="text"><?php echo trim($text_button_search); ?></span>
                                    <?php
                                } ?>
                            </button>
                            <div class="xptheme-search-clear"></div>
                        </div>

                        <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                        </div>
                        
                    </div>
                </form>
            </div>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Search_Form());
