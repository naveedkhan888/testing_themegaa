<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Button')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Themename_Elementor_Button extends Themename_Elementor_Widget_Base
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
        return 'xptheme-button';
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
        return esc_html__('Themename Button', 'themename');
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
        return 'eicon-button';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Button', 'themename'),
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label' => esc_html__('Text Button', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'link_button',
            [
                'label' => esc_html__('Link Button', 'themename'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'themename')
            ]
        );
        $this->add_control(
            'add_icon',
            [
                'label' => esc_html__('Add Icon', 'themename'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'icon_button',
            [
                'label' => esc_html__('Choose Icon', 'themename'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'xp-icon xp-icon-arrow-right',
                    'library' => 'xptheme-custom',
                ],
                'condition' => [
                    'add_icon' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->style_button();
    }

    protected function style_button()
    {
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Style', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'style_button_align',
            [
                'label' => esc_html__('Alignment', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ], 
                'prefix_class' => 'align-',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button' => 'text-align: {{VALUE}}',
                ],
            ]
        ); 

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'style_button_typography',
                'selector' => '{{WRAPPER}} .xptheme-element-button > a',
            ]
        );

        $this->add_responsive_control(
            'style_button_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'style_button_padding',
            [
                'label'      => esc_html__('Padding', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-element-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'style_button_margin',
            [
                'label'      => esc_html__('Margin', 'themename'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .xptheme-element-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('style_button_tabs');

        $this->start_controls_tab(
            'style_button_tab_normal',
            [
                'label' => esc_html__('Normal', 'themename'),
            ]
        );

        $this->add_control(
            'style_button_bg',
            [
                'label' => esc_html__('Background', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .xptheme-element-button > a:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'style_button_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button > a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_button_tab_hover',
            [
                'label' => esc_html__('Hover', 'themename'),
            ]
        );

        $this->add_control(
            'style_button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button > a:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style_button_color_hover',
            [
                'label' => esc_html__('Hover Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptheme-element-button > a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_item()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $link = $settings['link_button']['url'];
        $is_external        = $link_button['is_external'];
        $nofollow           = $link_button['nofollow'];
        
        $attribute = '';
        if ($is_external === 'on') {
            $attribute .= 'target="_blank"';
        }

        if ($nofollow === 'on') {
            $attribute .= 'rel="nofollow"';
        } ?>
            <a href="<?php echo esc_url($link) ?>" <?php echo trim($attribute) ?>
                class="xptheme-btn-theme btn-theme"><span><?php echo trim($text_button); ?></span>
                <?php $this->render_item_icon($icon_button); ?>
            </a>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Button());