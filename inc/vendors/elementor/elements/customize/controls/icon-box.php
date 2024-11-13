<?php
if (!function_exists('lasa_section_icon_box')) {
    function lasa_section_icon_box($widget)
    {
        $widget->start_controls_tabs('tabs_icon_box_border_style');

        $widget->start_controls_tab(
            'tab_icon_box_border_style',
            [
                'label' => esc_html__('Normal', 'lasa'),
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $widget->add_control(
            'tab_icon_box_border_color',
            [
                'label' => esc_html__('Icon Border Color', 'lasa'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'view!' => 'default',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon-box-icon .elementor-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'tab_icon_box_border_style_hover',
            [
                'label' => esc_html__('Hover', 'lasa'),
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $widget->add_control(
            'tab_icon_box_border_color_hover',
            [
                'label' => esc_html__('Icon Border Color', 'lasa'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon-box-icon .elementor-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->add_control(
			'heading_background_icon',
			[
				'label' => esc_html__( 'Background Icon', 'lasa' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

        $widget->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_box_background_icon',
				'selector' => '{{WRAPPER}}.elementor-view-stacked .elementor-icon',
			]
		);
    }

    add_action('elementor/element/icon-box/section_style_icon/before_section_end', 'lasa_section_icon_box', 10, 2);
}