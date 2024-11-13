<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Image_Color_Tab')) {
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
class Lasa_Elementor_Image_Color_Tab extends Lasa_Elementor_Widget_Base
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
        return 'tbay-image-color-tab';
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
        return esc_html__('Lasa Image Color Tab', 'lasa');
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
        return 'eicon-tabs';
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


        $this->add_control(
            'general_heading_color',
            [
                'label' => esc_html__('List Color', 'lasa'),
                'type' => Controls_Manager::HEADING,
            ]
        );


        $color_arr = apply_filters( 'image_tab_list_color_array', array(1, 2, 3, 4) );

        foreach ($color_arr as &$value) {
            $this->add_control(
                'color_'.$value,
                [
                    'label' => esc_html__('Color ', 'lasa'). $value,
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gallery-color-picker-'.$value => '--color: {{VALUE}}; --border-color: {{VALUE}};',
                    ],
                ]
            );
        }
        

        $repeater = $this->register_tab_repeater();

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tab Items', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );


        $this->end_controls_section();
        $this->style_tabs();
    }

    protected function style_tabs()
    {
        $this->start_controls_section(
            'section_style_tabs',
            [
                'label' => esc_html__('Style', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'heading_tab_item',
            [
                'label' => esc_html__('Tab Item', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_item_typography',
                'selector' => '{{WRAPPER}} .nav-link',
            ]
        ); 


        $this->start_controls_tabs('item_tabs');

        $this->start_controls_tab(
            'item_tab_normal',
            [
                'label' => esc_html__('Normal', 'lasa'),
            ]
        );

        $this->add_control(
            'item_tab_color',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-link' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_tab_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
            ]
        );

        $this->add_control(
            'item_tab_color_hover',
            [
                'label' => esc_html__('Color', 'lasa'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-link:hover,
                    {{WRAPPER}} .nav-link.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'item_tab_margin',
            [
                'label' => esc_html__('Margin', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_responsive_control(
            'item_tab_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_color_tab_wrapper',
            [
                'label' => esc_html__('Color Item Wrapper', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'color_tab_wrapper_margin',
            [
                'label' => esc_html__('Margin', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tab-list-color' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );   

        $this->add_control(
            'heading_color_tab',
            [
                'label' => esc_html__('Color Item', 'lasa'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'color_tab_margin',
            [
                'label' => esc_html__('Margin', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tab-list-color .gallery-color-picker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_responsive_control(
            'color_tab_padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tab-list-color .gallery-color-picker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
                

        $this->end_controls_section();
    }

    private function register_tab_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tab_name',
            [
                'label' => esc_html__('Tab Title', 'lasa'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    
        $color_arr = apply_filters( 'image_tab_list_color_array', array(1, 2, 3, 4) );

        foreach ($color_arr as &$value) {
            $repeater->add_control(
                'tab_image_'.$value,
                [
                    'label' => esc_html__('Choose Image Color ', 'lasa'). $value,
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
        }

        return $repeater;
    }

    protected function render_tabs_title($tabs, $id) {
        $count = 0;
        ?>
        <div class="nav nav-tabs nav-image-color-title" id="tab-nav-image-color-<?php echo esc_attr( $id ); ?>" role="tablist">
            <?php foreach ($tabs as $key) : ?>
                <?php 
                    $class_active = ( $count === 0 ) ? 'active' : '';
                    $selected = ( $count === 0 ) ? 'true' : 'false';
                ?>

                <button class="nav-link <?php echo esc_attr( $class_active ); ?>" id="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" data-bs-toggle="tab" data-bs-target="#nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" type="button" role="tab" aria-controls="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" aria-selected="<?php echo esc_attr( $selected ) ?>"><span class="name"><?php echo trim($key['tab_name']); ?></span></button>

                <?php $count++; ?>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function render_tabs_content($tabs, $id) {
        $count = 0;
        ?>
        <div class="tab-content nav-image-color-content" id="nav-content-image-color-<?php echo esc_attr( $id ); ?>">
            <?php foreach ($tabs as $key) : ?>
            <?php 
                $class_active = ( $count === 0 ) ? 'show active' : '';
            ?>

            <div class="tab-pane fade <?php echo esc_attr( $class_active ); ?>" id="nav-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>" role="tabpanel" aria-labelledby="nav-tab-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr($key['_id']); ?>">
                <?php 
                    $color_arr = apply_filters( 'image_tab_list_color_array', array(1, 2, 3, 4) );

                    foreach ($color_arr as &$value) {
                        $this->print_render_widget_field_img($key['tab_image_'. $value], 'color-'. $value); 
                    }
                ?>
            </div>

            <?php $count++; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function render_list_color() {
        ?>
        <div class="tab-list-color">
            <?php 
                $color_arr = apply_filters( 'image_tab_list_color_array', array(1, 2, 3, 4) );
                $count = 0;
                foreach ($color_arr as &$value) {
                    $class_active = ( $count === 0 ) ? ' active' : '';
                    echo '<button data-color="color-'. esc_attr($value) .'" class="gallery-color-picker gallery-color-picker-'. esc_attr($value) . $class_active. '"></button>'; 
                    $count++;
                }
            ?>
        </div>
        <?php
    }
}
$widgets_manager->register(new Lasa_Elementor_Image_Color_Tab());