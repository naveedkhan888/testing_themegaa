<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Canvas_Menu_Template')) {
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
class Themename_Elementor_Canvas_Menu_Template extends Themename_Elementor_Widget_Base
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
        return 'xptheme-canvas-menu-template';
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
        return esc_html__('Themename Canvas Menu Template', 'themename');
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
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return [ 'themename-elements', 'themename-header'];
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'themename'),
            ]
        );
        
        $this->add_control(
            'icon_menu_canvas',
            [
                'label' => esc_html__('Choose Icon', 'themename'),
                'type' => Controls_Manager::ICONS,
            ]
        );
        
        $templates = Elementor\Plugin::instance()->templates_manager->get_source('local')->get_items();

        if (empty($templates)) {
            $this->add_control(
                'no_templates',
                [
                    'label' => false,
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no templates in your site.</strong><br>Go to the <a href="%s" target="_blank">Templates screen</a> to create one.', 'themename'), admin_url('edit.php?post_type=elementor_library&tabs_group=library')),
                ]
            );

            return;
        }

        $options = [
            '0' => '— ' . esc_html__('Select', 'themename') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $this->add_control(
            'template_id',
            [
                'label' => esc_html__('Choose Template', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $options,
                'types' => $types,
                'label_block'  => 'true',
            ]
        );
        
        $this->add_responsive_control(
            'canvas_menu_align',
            [
                'label' => esc_html__('Content Align', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'menu-canvas-',
            ]
        );

        $this->end_controls_section();
        $this->register_style_canvas_menu();
    }
    public function register_style_canvas_menu()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('General', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_menu_size',
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
                    '{{WRAPPER}} .btn-canvas-menu > i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );
        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }
    public function render_content_template()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (empty($template_id)) return;
        
        if( $canvas_menu_align === 'left' ) {
            $offcanvas_position = 'offcanvas-start';
        } else {
            $offcanvas_position = 'offcanvas-end';
        }
        ?>
        <div class="canvas-menu-content offcanvas <?php echo esc_attr($offcanvas_position); ?>" id="menu-template-<?php echo esc_attr($this->get_id()); ?>">
            <a href="javascript:void(0);" class="close-canvas-menu" data-bs-dismiss="offcanvas"><i class="zmdi zmdi-close"></i></a>
            <div class="canvas-content-ajax">
            <?php
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, themename_get_elementor_css_print_method() );
        echo "</div></div>";
    }
    public function render_canvas_menu()
    {
        $settings = $this->get_settings_for_display();
        extract($settings); ?>
        <div class="canvas-menu-sidebar">
            <a href="javascript:void(0);" data-id="<?php echo esc_attr($template_id); ?>" class="btn-canvas-menu menu-click" data-bs-toggle="offcanvas" data-bs-target="#menu-template-<?php echo esc_attr($this->get_id()); ?>" aria-controls="menu-template-<?php echo esc_attr($this->get_id()); ?>"> 
                <?php $this->render_item_icon($icon_menu_canvas); ?>
            </a>
            
            <?php $this->render_content_template(); ?> 
        </div><?php
    }
}
$widgets_manager->register(new Themename_Elementor_Canvas_Menu_Template());
