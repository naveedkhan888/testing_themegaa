<?php

if (! defined('ABSPATH') || function_exists('Lasa_Elementor_Portfolios')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Lasa_Elementor_Portfolios extends Lasa_Elementor_Carousel_Base
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
        return 'tbay-portfolios';
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
        return esc_html__('Lasa Portfolios', 'lasa');
    }

    public function get_script_depends() {
        return [ 'isotope', 'lasa-custom-slick', 'slick' ];
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
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'lasa'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'filter',
                'options'   => [
                    'filter'      => esc_html__('Filter', 'lasa'),
                    'grid'      => esc_html__('Grid', 'lasa'),
                    'carousel'  => esc_html__('Carousel', 'lasa'),
                ],
                'separator'    => 'after',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number Of Portfolios', 'lasa'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of portfolios to show ( -1 = all )', 'lasa'),
                'default' => -1,
                'min'  => -1
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'options'   => [
                    'DESC'     =>  'DESC',
                    'ASC'      =>  'ASC',
                ],
                'default' => 'ASC',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'options'   => [
                    'none'     =>  'None',
                    'ID'      =>  'ID',
                    'author'      =>  'Author',
                    'title'      =>  'Title',
                    'name'      =>  'Name',
                    'date'      =>  'Date',
                    'modified'      =>  'Modified',
                    'rand'      =>  'Random',
                    'menu_order'      =>  'Menu Order',
                ],
                'default' => 'date',
            ]
        );

        $repeater = $this->register_filters_repeater();

        $this->add_control(
            'filters',
            [
                'label' => esc_html__('Tags Filters', 'lasa'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => [
                    'layout_type' => 'filter'
                ],
            ]
        );

        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_section_styles_filter_tabs(['layout_type' => 'filter']);
    }

    private function register_section_styles_filter_tabs($condition)
    {
        $this->start_controls_section(
            'section_style_filter_content',
            [
                'label' => esc_html__('Heading Filter', 'lasa'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'filter_style_margin_content',
            [
                'label' => esc_html__('Margin Content', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} #pf-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_style_align',
            [
                'label' => esc_html__('Align', 'lasa'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lasa'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lasa'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lasa'),
                        'icon' => 'eicon-text-align-right'
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} #pf-filters'  => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_style_button_typography',
                'selector' => '{{WRAPPER}} #pf-filters .button',
            ]
        );

        $this->add_control(
			'filter_style_button_color',
			[
				'label' => esc_html__( 'Color', 'lasa' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #pf-filters .butto' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'filter_style_margin',
            [
                'label' => esc_html__('Margin Item', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} #pf-filters .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_style_padding',
            [
                'label' => esc_html__('Padding Item', 'lasa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} #pf-filters .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_filters_repeater()
    {
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'filter_tag',
            [
                'label' => esc_html__('Tag', 'lasa'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
				'multiple' => true,
                'options' => $this->get_options_list_tags(),
            ]
        );

        return $repeater;
    }


    private function get_options_list_tags($number = '')
    {
        $args = array(
            'taxonomy'   => 'portfolio-tag',
            'hide_empty' => false,
        );
        if ($number === 0) {
            return;
        }
        if (!empty($number) && $number !== -1) {
            $args['number'] = $number;
        }

        $categories = get_terms($args);
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[lasa_get_transliterate($category->slug)] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }

    public function render_portfolios_filters() {
        $settings = $this->get_settings_for_display();
        $filters = $settings['filters'];

        if (empty($filters)) {
            return;
        }

        foreach ($filters as $key) {
            echo '<button class="button" data-filter=".'. esc_attr($key['filter_tag']) .'">'. trim($key['filter_tag']) .'</button>';
        }
    }

    public function render_portfolios_content() {
        $settings = $this->get_settings_for_display();

        $args = apply_filters('element_portfolios_query_filter', array(
            'post_type'      => 'tb_portfolio',
            'posts_per_page'=> $settings['limit'],
            'order' => $settings['order'],
            'orderby' => $settings['orderby'],
        ));

        $portfolios_query = new WP_Query( $args );

        // The Loop.
        if ( $portfolios_query->have_posts() ) {

            while ( $portfolios_query->have_posts() ) {
                $portfolios_query->the_post();
                ?>
                <div class="element-item <?php echo esc_attr($this->get_list_terms_tags(get_the_ID(), ' ')); ?>">
                    <div class="item-content">
                        <?php 
                        
                        if ( has_post_thumbnail()) {
                            echo '<div class="item-img">'. get_the_post_thumbnail( null, 'full' ) .'</div>';
                        }
                        ?>
                        <div class="item-info-wrapper">
                        <div class="item-info">
                                <a class="item-link" target="_blank" href="<?php echo esc_url( get_permalink() ); ?>"><i class="tb-icon tb-icon-search"></i></a>
                                    <div class="item-title"><a class="item-title-link" target="_blank" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></div>

                                    <?php 
                                        if( !empty($this->get_list_terms_tags(get_the_ID(), ' ')) ) {
                                            echo '<div class="item-tags"><i class="tb-icon tb-icon-tag"></i>' .$this->get_list_terms_tags(get_the_ID(), ', '). '</div>'; 
                                        }
                                    ?>
                        </div>
                        </div>
                    </div>
                </div>
                <?php
            }

            // Restore original Post Data.
            wp_reset_postdata();
        } else {
            esc_html_e( 'Sorry no portfolio, please add a new portfolio', 'lasa' );
        }
    }

    private function get_list_terms_tags($post_id, $space_default) {
        $tags = get_the_terms($post_id, 'portfolio-tag');

        if( empty($tags) ) return;

        $list_tags ='';
        $count = 0;
        $numer = count($tags);
        foreach($tags as $tag) {
            $space = $space_default;
            if(++$count === $numer) $space = '';

            $list_tags .= $tag->slug.$space;
        }

        return $list_tags;
    }
}
$widgets_manager->register(new Lasa_Elementor_Portfolios());