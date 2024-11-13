<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Widget_Image')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Themename_Element_Site_Logo extends Themename_Elementor_Widget_Image
{
    public function get_name()
    {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'themename-site-logo';
    }

    public function get_title()
    {
        return esc_html__('Themename Site Logo', 'themename');
    }

    public function get_keywords()
    {
        return [ 'header', 'logo' ];
    }
    
    public function get_icon()
    {
        return 'eicon-site-logo';
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
            'image_logo',
            [
                'label' => esc_html__('Choose Image', 'themename'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $this->end_controls_section();
        

        parent::register_controls();
        $this->remove_control('image');
        $this->remove_control('section_style_image');
        $this->remove_control('caption_source');
        $this->update_control(
            'image_size',
            [
                'default' => 'full',
                'condition' => '',
            ]
        );

        $this->update_control(
            'link_to',
            [
                'default' => 'home',
                'options' => [
                    'none' => esc_html__('None', 'themename'),
                    'home' => esc_html__('Home Page', 'themename'),
                    'custom' => esc_html__('Custom URL', 'themename'),
                ],
                'condition' => '',
            ]
        );
 

        $this->update_control(
            'link',
            [
                'placeholder' => get_home_url(),
                'condition' => [
                    'link_to' => 'custom',
                ],
            ]
        );
        $this->register_style_logo();
    }

    public function register_style_logo()
    {
        $this->start_controls_section(
            'section_style_logo',
            [
                'label' => esc_html__('Logo', 'themename'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'width_logo',
            [
                'label' => esc_html__('Max Width', 'themename'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 400,
                    ],
                    
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    public static function get_logo_default_image_src()
    {
        $logo_image = THEMENAME_IMAGES . '/logo-default.svg';

        /**
         * Get default image logo source.
         *
         * Filters the source of the default placeholder image used by Elementor.
         *
         * @since 1.0.0
         *
         * @param string $logo_image The source of the default placeholder image.
         */
        $logo_image = apply_filters('elementor/header/get_logo_default_image_src', $logo_image);

        return $logo_image;
    }

    protected function get_html_wrapper_class()
    {
        return parent::get_html_wrapper_class() . ' w-auto elementor-widget-' . parent::get_name();
    }
 
    protected function get_link_url($settings)
    {
        if ('none' === $settings['link_to']) {
            return false;
        }

        if ('home' === $settings['link_to']) {
            $settings['link']['url'] = apply_filters('wpml_home_url', get_home_url());

            return $settings['link'];
        }

        if ('custom' === $settings['link_to']) {
            return $settings['link'];
        }
    }

    protected function content_template()
    {
        return;
    }
}
$widgets_manager->register(new Themename_Element_Site_Logo());
