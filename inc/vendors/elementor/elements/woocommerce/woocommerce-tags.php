<?php

if (! defined('ABSPATH') || function_exists('Themename_Elementor_Woocommerce_Tags')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Themename_Elementor_Woocommerce_Tags extends Themename_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'xptheme-woocommerce-tags';
    }

    public function get_title()
    {
        return esc_html__('Themename Woocommerce Tags', 'themename');
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
        return [ 'woocommerce-elements', 'woocommerce-tags' ];
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
            'limit',
            [
                'label' => esc_html__('Number tag to show ( -1 = all )', 'themename'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min'  => -1
            ]
        );

        $this->end_controls_section();
    }
    public function render_item()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ($limit === 0) {
            echo '<p>'. esc_html__('Please select the number of tags again', 'themename') .'</p>';
            return;
        }

        $taxonomy = 'product_tag';

        $args = array(
            'taxonomy' => $taxonomy
        );

        if ($limit !== -1) {
            $args['number'] = $limit;
        }

        $tags = get_terms($args);

        $list = '';
        if ($tags && is_array($tags)) {
            if (!empty($tags)) {
                $list .= '<ul class="list-tags">';
                foreach ($tags as $tag) {
                    $term_link = get_term_link($tag->term_id, $taxonomy);
                    $name =  apply_filters('the_title', $tag->name);
                    $list .= '<li><a class="category_links" href="' . esc_url($term_link) . '">' . trim($name) . '</a></li>';
                }
                $list .= '</ul>';
            }
        } else {
            $list .= '<p>'. esc_html__('Sorry, but no tags were found', 'themename') .'</p>';
        }

        echo trim($list);
    }
}
$widgets_manager->register(new Themename_Elementor_Woocommerce_Tags());
