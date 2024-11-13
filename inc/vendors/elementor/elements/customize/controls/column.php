<?php

if (!function_exists('lasa_column_section_advanced')) {
    function lasa_column_section_advanced($widget)
    {
        $widget->update_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'lasa'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} > div.elementor-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
    }

    add_action('elementor/element/column/section_advanced/before_section_end', 'lasa_column_section_advanced', 10, 2);
}