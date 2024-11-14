<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Our_Team')) {
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
class Themename_Elementor_Our_Team extends Themename_Elementor_Carousel_Base
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
        return 'xptheme-our-team';
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
        return esc_html__('Themename Our Team', 'themename');
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
        return 'eicon-person';
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
                'label' => esc_html__('Layout Style', 'themename'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style3',
                'options'   => [
                    'style1'      => esc_html__('Style 1', 'themename'),
                    'style2'  => esc_html__('Style 2', 'themename'),
                    'style3'  => esc_html__('Style 3', 'themename'),
                ],
            ]
        );
        
        
        $repeater = $this->register_our_team_repeater();

        $this->add_control(
            'our_team',
            [
                'label' => esc_html__('Our Team Items', 'themename'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_our_team_default(),
                'our_team_field' => '{{{ our_team_image }}}',
            ]
        );

        

        $this->end_controls_section();
        $this->style_our_team();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }
    protected function style_our_team()
    {
        $this->start_controls_section(
            'section_style_our_team',
            [
                'label' => esc_html__('Style Our Team', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'our_team_align',
            [
                'label' => esc_html__('Align', 'themename'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themename'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themename'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themename'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .info'  => 'text-align: {{VALUE}}',
                ]
            ]
        );
        $this->add_control(
            'heading_name',
            [
                'label' => esc_html__('Name', 'themename'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'our_team_name_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .name-team'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'our_team_name_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .name-team' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'our_team_name_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .name-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_job',
            [
                'label' => esc_html__('Job', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_responsive_control(
            'our_team_job_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'our_team_job_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .job' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'our_team_job_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .job'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'heading_description',
            [
                'label' => esc_html__('Description', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_responsive_control(
            'our_team_description_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'our_team_description_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'our_team_description_color',
            [
                'label' => esc_html__('Color', 'themename'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .description'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_image',
            [
                'label' => esc_html__('Image', 'themename'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_responsive_control(
            'our_team_image_margin',
            [
                'label' => esc_html__('Margin', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .our-team-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'our_team_image_padding',
            [
                'label' => esc_html__('Padding', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .our-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius Image', 'themename'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .our-team-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_our_team_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'our_team_name',
            [
                'label' => esc_html__('Name', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'our_team_job',
            [
                'label' => esc_html__('Job', 'themename'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'our_team_description',
            [
                'label' => esc_html__('Description', 'themename'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'our_team_image',
            [
                'label' => esc_html__('Choose Image', 'themename'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'our_team_link_fb',
            [
                'label' => esc_html__('FaceBook Link', 'themename'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'themename'),
            ]
        );
        $repeater->add_control(
            'our_team_link_tw',
            [
                'label' => esc_html__('Twitter Link', 'themename'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'themename'),
            ]
        );
        $repeater->add_control(
            'our_team_link_gg',
            [
                'label' => esc_html__('Goole Plus Link', 'themename'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'themename'),
            ]
        );
        $repeater->add_control(
            'our_team_link_linkin',
            [
                'label' => esc_html__('Linkin Link', 'themename'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'themename'),
            ]
        );
        $repeater->add_control(
            'our_team_link_instaram',
            [
                'label' => esc_html__('Instagram Link', 'themename'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'themename'),
            ]
        );

        return $repeater;
    }

    private function register_set_our_team_default()
    {
        $defaults = [
            [
                'our_team_name' => esc_html__('Name 1', 'themename'),
                'our_team_job' => esc_html__('Job 1', 'themename'),
                'our_team_description' => esc_html__('Description 1', 'themename'),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_tw' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_gg' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_linkin' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_instaram' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ],
            [
                'our_team_name' => esc_html__('Name 2', 'themename'),
                'our_team_job' => esc_html__('Job 2', 'themename'),
                'our_team_description' => esc_html__('Description 2', 'themename'),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_tw' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_gg' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_linkin' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_instaram' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ],
            [
                'our_team_name' => esc_html__('Name 3', 'themename'),
                'our_team_job' => esc_html__('Job 3', 'themename'),
                'our_team_description' => esc_html__('Description 3', 'themename'),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_tw' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_gg' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_linkin' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_instaram' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ],
            [
                'our_team_name' => esc_html__('Name 4', 'themename'),
                'our_team_job' => esc_html__('Job 4', 'themename'),
                'our_team_description' => esc_html__('Description 4', 'themename'),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_tw' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_gg' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_linkin' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'our_team_link_instaram' =>  [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ],
        ];

        return $defaults;
    }

    protected function render_item_style1($item)
    {
        extract($item); ?> 
        <div class="inner"> 
           <?php

                $array_link = [
                    'fb' => 'icon-social-facebook',
                    'tw' => 'icon-social-twitter',
                    'gg' => 'icon-social-google',
                    'linkin' => 'icon-social-linkedin',
                    'instaram' => 'icon-social-instagram'
                ]; ?>

            <div class="our-team-content">
                <?php $this->print_render_widget_field_img($item['our_team_image']); ?>
            </div>
            <div class="info">
                <?php 
                    echo ( !empty($our_team_name) ) ? '<h3 class="name-team">'. trim($our_team_name) .'</h3>' : '';
                    echo ( !empty($our_team_job) ) ? '<h5 class="job">'. trim($our_team_job) .'</h5>' : '';
                ?>  
                <?php 
                    echo ( !empty($our_team_description) ) ? '<p class="description">'. trim($our_team_description) .'</p>' : '';
                ?>    
            </div>
            <ul class="social-link">
                <?php
                    foreach ($array_link as $key => $value) {
                        $link = $item['our_team_link_'.$key]['url'];
                        $attribute = '';

                        if ($item['our_team_link_'.$key]['is_external'] === 'on') {
                            $attribute .= ' target="_blank"';
                        }
    
                        if ($item['our_team_link_'.$key]['nofollow'] === 'on') {
                            $attribute .= ' rel="nofollow"';
                        } ?>
                        <?php if (!empty($link) && isset($link)) {
                            ?>
                                <li>
                                    <a href="<?php echo esc_url($link); ?>">
                                        <i class="icons <?php echo esc_attr($value); ?>"></i>
                                    </a>
                                </li>
                            <?php
                        } ?>
                    <?php
                    } ?>
            </ul>
        </div>
        <?php
    }

    protected function render_item_style2($item)
    {
        extract($item); ?> 
        <div class="inner"> 
           <?php

                $array_link = [
                    'fb' => 'icon-social-facebook',
                    'tw' => 'icon-social-twitter',
                    'gg' => 'icon-social-google',
                    'linkin' => 'icon-social-linkedin',
                    'instaram' => 'icon-social-instagram'
                ]; ?>

            <div class="our-team-content">
                <?php $this->print_render_widget_field_img($item['our_team_image']); ?>

                <div class="info">  
                    <?php 
                        echo ( !empty($our_team_name) ) ? '<h3 class="name-team">'. trim($our_team_name) .'</h3>' : '';
                        echo ( !empty($our_team_job) ) ? '<h5 class="job">'. trim($our_team_job) .'</h5>' : '';
                    ?>  

                    <ul class="social-link">
                        <?php
                            foreach ($array_link as $key => $value) {
                                $link = $item['our_team_link_'.$key]['url'];
                                $attribute = '';

                                if ($item['our_team_link_'.$key]['is_external'] === 'on') {
                                    $attribute .= ' target="_blank"';
                                }
            
                                if ($item['our_team_link_'.$key]['nofollow'] === 'on') {
                                    $attribute .= ' rel="nofollow"';
                                } ?>
                                <?php if (!empty($link) && isset($link)) {
                                    ?>
                                        <li>
                                            <a href="<?php echo esc_url($link); ?>">
                                                <i class="icons <?php echo esc_attr($value); ?>"></i>
                                            </a>
                                        </li>
                                    <?php
                                } ?>
                            <?php
                            } ?>
                    </ul>
                </div>
            </div>
            <?php 
                echo ( !empty($our_team_description) ) ? '<p class="description">'. trim($our_team_description) .'</p>' : '';
            ?>  
        </div>
        <?php
    }
    protected function render_item_style3($item)
    {
        extract($item); ?> 
        <div class="inner"> 
           <?php

                $array_link = [
                    'fb' => 'icon-social-facebook',
                    'tw' => 'icon-social-twitter',
                    'gg' => 'icon-social-google',
                    'linkin' => 'icon-social-linkedin',
                    'instaram' => 'icon-social-instagram'
                ]; ?>

            <div class="our-team-content">
                <?php $this->print_render_widget_field_img($item['our_team_image']); ?>

                <div class="social-link-wrapper">
                    <ul class="social-link">
                        <?php
                            foreach ($array_link as $key => $value) {
                                $link = $item['our_team_link_'.$key]['url'];
                                $attribute = '';

                                if ($item['our_team_link_'.$key]['is_external'] === 'on') {
                                    $attribute .= ' target="_blank"';
                                }
            
                                if ($item['our_team_link_'.$key]['nofollow'] === 'on') {
                                    $attribute .= ' rel="nofollow"';
                                } ?>
                                <?php if (!empty($link) && isset($link)) {
                                    ?>
                                        <li>
                                            <a href="<?php echo esc_url($link); ?>">
                                                <i class="icons <?php echo esc_attr($value); ?>"></i>
                                            </a>
                                        </li>
                                    <?php
                                } ?>
                            <?php
                            } ?>
                    </ul>
                </div>
            </div>

            <div class="info">  
                <?php 
                    echo ( !empty($our_team_name) ) ? '<h3 class="name-team">'. trim($our_team_name) .'</h3>' : '';
                    echo ( !empty($our_team_job) ) ? '<h5 class="job">'. trim($our_team_job) .'</h5>' : '';
                    echo ( !empty($our_team_description) ) ? '<p class="description">'. trim($our_team_description) .'</p>' : '';
                ?>  
            </div>
        </div>
        <?php
    }
}
$widgets_manager->register(new Themename_Elementor_Our_Team());
