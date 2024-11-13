<?php
if (!function_exists('lasa_section_sticky_header')) {
    function lasa_section_sticky_header($element)
    {
        if (get_post_type() !== 'tbay_custom_post') {
            return;
        }

        global $post;

        $block_type = get_post_meta($post->ID, 'tbay_block_type', true);

        if( $block_type !== 'type_header' ) {
            return;
        }

        $element->start_controls_section(
            'sticky_header',
            array(
                'label' => esc_html__('Sticky Header', 'lasa'),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            )
        );

        $element->add_control(
            'enable_sticky_headers',
            array(
                'label'                 =>  esc_html__('Enable Sticky Headers', 'lasa'),
                'type'                  => \Elementor\Controls_Manager::SWITCHER,
                'default'               => '',
                'description' => esc_html__( 'This feature only works on wrapping elements, not on child elements', 'lasa' ),
                'return_value'          => 'yes',
            )
        );

        $element->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array( 
                'name'        => 'sticky_headers_border', 
                'selector' => '{{WRAPPER}}.sticky',
                'condition' => [
                    'enable_sticky_headers' => 'yes'
                ],
                'separator'   => 'before',
            )
        );

        $element->add_control(
            'sticky_headers_bg',
            [
                'label'     => esc_html__('Background Color', 'lasa'),
                'description' => esc_html__( 'Background color when the sticky section', 'lasa' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'enable_sticky_headers' => 'yes'
                ],
                'separator'   => 'before',
                'selectors' => [
                    '{{WRAPPER}}.sticky' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $element->end_controls_section();
    }

    add_action('elementor/element/section/section_layout/after_section_end', 'lasa_section_sticky_header', 10, 2);
    add_action('elementor/element/container/section_layout_container/after_section_end', 'lasa_section_sticky_header', 10, 2);
}
