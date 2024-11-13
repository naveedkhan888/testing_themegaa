<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Store_Notice')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Lasa_Elementor_Store_Notice extends Lasa_Elementor_Widget_Base
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
        return 'tbay-store-notice';
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
        return esc_html__('Lasa Store Notice', 'lasa');
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
        return 'eicon-notification';
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
                'label' => esc_html__('General', 'lasa'),
            ]
        );

        $repeater = $this->register_tab_repeater();

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs Notice', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'marquee_timing',
            [
                'label' => esc_html__('Marquee Timing', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .noticeMarquee .content' => '--lasa-marquee-timing: {{VALUE}}s;',
                ],
                'description' => esc_html__('Marquee speed up and slow down', 'lasa'),
            ]
        );


        $this->end_controls_section();

        $this->style_tab_content_section();
    }

    private function register_tab_repeater()
    {
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Content', 'lasa'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        return $repeater;
    }

    private function style_tab_content_section()
    {
        $this->start_controls_section(
            'section_style_tab_content',
            [
                'label' => esc_html__('Content', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_content_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .noticeMarquee .content > p',
            ]
        ); 

        $this->start_controls_tabs('tab_content_tabs');

        $this->start_controls_tab(
            'tab_content_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'tab_content_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .noticeMarquee .content > p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_content_bg',
            [
                'label' => esc_html__('Background', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .noticeMarquee .content' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'tab_content_color_hover',
            [
                'label' => esc_html__('Color Hover', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .noticeMarquee .content > p:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'tab_content_bg_hover',
            [
                'label' => esc_html__('Background Hover', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .noticeMarquee .content:hover' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        
        $this->add_responsive_control(
            'tab_content_padding',
            [
                'label'      => esc_html__('Padding', 'lasa'),
                'separator' => 'before',
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .noticeMarquee .content > p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_content_margin',
            [
                'label'      => esc_html__('Margin', 'lasa'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .noticeMarquee .content > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render_tabs_content($tabs) {
        ?>
        <div class="noticeMarquee">
            <div class="content">
                <?php foreach ($tabs as $key) : ?>
                    <p class="item"><?php echo trim($key['tab_content']); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
$widgets_manager->register(new Lasa_Elementor_Store_Notice());