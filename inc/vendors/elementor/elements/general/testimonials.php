<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Testimonials')) {
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
class Themename_Elementor_Testimonials extends Themename_Elementor_Carousel_Base
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
        return 'tbay-testimonials';
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
        return esc_html__('Themename Testimonials', 'themename');
    }

    public function get_script_depends()
    {
        return [ 'themename-custom-slick', 'slick' ];
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
        return 'eicon-testimonial';
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
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
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

        $this->add_control(
            'layout_style',
            [
                'label'     => esc_html__('Layout Style', 'themename'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'style1',
                'options'   => [
                    'style1'    => esc_html__('Style 1', 'themename'),
                    'style2'    => esc_html__('Style 2', 'themename'),
                    'style3'    => esc_html__('Style 3', 'themename'),
                    'style4'    => esc_html__('Style 4', 'themename'),
                ],
            ]
        );

        $repeater = $this->register_testimonials_repeater();

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials Items', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'condition' => [
                    'layout_style!' => 'style4'
                ],
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_testimonial_default(),
                'testimonials_field' => '{{{ testimonials_image }}}',
            ]
        ); 

        $repeater_style4 = $this->register_testimonials_repeater_style4();

        $this->add_control(
            'testimonials_style4',
            [
                'label' => esc_html__('Testimonials Items', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'condition' => [
                    'layout_style' => 'style4'
                ],
                'fields' => $repeater_style4->get_controls(),
            ]
        ); 

        $this->end_controls_section();

        $this->style_testimonials();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function style_testimonials()
    {
        $this->start_controls_section(
            'section_style_testimonials',
            [
                'label' => esc_html__('Style Testimonials', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_style_testimonials_content',
            [
                'label' => esc_html__('Content', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        
        $this->add_responsive_control(
            'testimonials_content_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '.rtl {{WRAPPER}} .testimonial-right' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} !important;',
                ],
            ]
        );


        $this->add_control(
            'heading_style_testimonials_description',
            [
                'label' => esc_html__('Description', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_description_typography',
                'selector' => '{{WRAPPER}} .excerpt',
            ]
        ); 

        $this->add_control(
            'testimonials_description_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonials_description_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'heading_style_testimonials_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_subtitle_typography',
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        ); 

        $this->add_control(
            'testimonials_subtitle_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonials_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        
        $this->add_control(
            'heading_style_testimonials_name',
            [
                'label' => esc_html__('Name', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_name_typography',
                'selector' => '{{WRAPPER}} .name',
            ]
        ); 

        $this->add_control(
            'testimonials_name_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonials_name_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

                
        $this->add_control(
            'heading_style_testimonials_subname',
            [
                'label' => esc_html__('Sub Name', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonials_subname_typography',
                'selector' => '{{WRAPPER}} .sub-name',
            ]
        ); 

        $this->add_control(
            'testimonials_subname_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sub-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonials_subname_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sub-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'heading_style_testimonials_img',
            [
                'label' => esc_html__('Image', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'testimonials_img_max_width',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 
                        'min' => 40,
                        'max' => 600,
                    ],
                ],
                'selectors' => [
					'{{WRAPPER}} .testimonials-body .testimonial-img img' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
            ]
        );
        $this->add_responsive_control(
            'testimonials_img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-body .testimonial-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonials_img_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-body .testimonial-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonials_img_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-body .testimonial-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
                

        $this->end_controls_section();
    }

    private function register_testimonials_repeater()
    {
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Choose Image: Avatar', 'themename'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $repeater->add_control(
            'title_excerpt',
            [
                'label' => esc_html__('Excerpt', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $repeater->add_control(
            'testimonial_excerpt',
            [
                'label' => esc_html__('Description', 'themename'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        $repeater->add_control(
            'testimonial_subtitle',
            [
                'label' => esc_html__('Sub-title', 'themename'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        
        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'testimonial_sub_name',
            [
                'label' => esc_html__('Sub Name', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        return $repeater;
    }

    private function register_testimonials_repeater_style4()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title_excerpt',
            [
                'label' => esc_html__('Excerpt', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $repeater->add_control(
            'testimonial_excerpt',
            [
                'label' => esc_html__('Description', 'themename'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        
        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'testimonial_subtitle',
            [
                'label' => esc_html__('Sub Title', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_label_date',
            [
                'label' => esc_html__('Label Date', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        return $repeater;
    }

    private function register_set_testimonial_default()
    {
        $defaults = [
            [
                
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 1', 'themename'),
                'testimonial_sub_name' => esc_html__('Sub name 1', 'themename'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'themename'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'themename'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 2', 'themename'),
                'testimonial_sub_name' => esc_html__('Sub name 2', 'themename'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'themename'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'themename'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 3', 'themename'),
                'testimonial_sub_name' => esc_html__('Sub name 3', 'themename'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'themename'),
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'themename'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                
                'testimonial_name' => esc_html__('Name 4', 'themename'),
                'testimonial_sub_name' => esc_html__('Sub name 4', 'themename'),
                'testimonial_excerpt' => 'Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque',
                'testimonial_subtitle' => esc_html__('This is text sub-title', 'themename'),
            ],
        ];

        return $defaults;
    }

    protected function render_item_style1($item)
    {
        ?> 
        <div class="testimonials-body style1"> 
                <div class="testimonial-meta">
                    <div class="testimonials-info-wrapper d-flex">
                        <div class="testimonial-img flex-shrink-0">
                            <?php $this->print_render_widget_field_img($item['testimonial_image']); ?>
                        </div>

                        <div class="testimonial-right flex-grow-1">
                            <img class="testimonial-qs" alt="<?php esc_attr_e('testimonial qs', 'themename'); ?>" src="<?php echo esc_url_raw(THEMENAME_IMAGES .'/testi-qs.png') ?>">
                            <div class="testimonial-rating"></div>
                            <?php $this->render_item_excerpt($item); ?>
                            <?php $this->render_item_subtitle($item); ?>

                            <div class="testimonials-info">
                                <?php  
                                    $this->render_item_name($item); 
                                    $this->render_item_sub_name($item);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                ?>
                <?php
            ?>
        </div>
        <?php
    }
    

    protected function render_item_style2($item)
    {
        ?> 
        <div class="testimonials-body style2"> 
            <div class="testimonial-meta">
                <div class="testimonials-img">
                    <?php $this->print_render_widget_field_img($item['testimonial_image']); ?>
                </div>
                <div class="testimonials-info-wrapper">
                    <?php $this->render_item_excerpt($item); ?>
                    
                    <div class="testimonial-rating"></div>

                    <div class="d-flex justify-content-center flex-testimonials">
                        <div class="testimonials-name-sub">
                            <?php  
                                $this->render_item_name($item); 
                                $this->render_item_sub_name($item);
                            ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php
    }

    protected function render_item_style3($item)
    {
        ?> 
        <div class="testimonials-body style3"> 
            <div class="testimonial-meta">
                <div class="testimonials-info-wrapper">
                    <div class="testimonials-info d-flex">
                        <div class="flex-shrink-0">
                            <?php $this->print_render_widget_field_img($item['testimonial_image']); ?>
                        </div>
                        <div class="testimonials-info-right flex-grow-1 ms-3">
                            <?php  
                                $this->render_item_name($item); 
                                $this->render_item_sub_name($item);
                            ?>
                        </div>
                    </div>

                    <div class="testimonial-rating"></div>
                </div>
                <?php $this->render_item_excerpt($item); ?>
            </div>
        </div>
        <?php
    }

    protected function render_item_style4($item)
    {
        ?> 
        <div class="testimonials-body style4"> 
            <div class="testimonial-meta">
                <div class="testimonial-meta-top">
                    <div class="testimonial-rating"></div>
                    <?php $this->render_item_label_date($item); ?>
                </div>

                <div class="testimonials-info-wrapper">
                    <?php 
                         $this->render_item_subtitle($item);
                         $this->render_item_excerpt($item);
                         $this->render_item_name($item);
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    

    private function render_item_name($item)
    {
        $element  = $item['testimonial_name'];
        if (isset($element) && !empty($element)) {
            ?>
                <span class="name"><?php echo trim($element); ?></span>
            <?php
        }
    }
    private function render_item_sub_name($item)
    {
        $element  = $item['testimonial_sub_name'];

        if (isset($element) && !empty($element)) {
            ?>
                <span class="sub-name"><?php echo trim($element) ?></span>
            <?php
        }
    }

    private function render_item_label_date($item)
    {
        $element  = $item['testimonial_label_date'];

        if (isset($element) && !empty($element)) {
            ?>
                <div class="label-date"><?php echo trim($element) ?></div>
            <?php
        }
    }

    private function render_item_excerpt($item)
    {
        $element  = $item['testimonial_excerpt'];

        if ( isset($element) && !empty($element) ) {
            ?>  
                <div class="excerpt"><?php echo trim($element) ?></div>
            <?php
        }
    }

    private function render_item_subtitle($item)
    {
        $element  = $item['testimonial_subtitle'];

        if ( isset($element) && !empty($element) ) {
            ?>  
                <div class="subtitle"><?php echo trim($element) ?></div>
            <?php
        }
    }
}
$widgets_manager->register(new Themename_Elementor_Testimonials());
