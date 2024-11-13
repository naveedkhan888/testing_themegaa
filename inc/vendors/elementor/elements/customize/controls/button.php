<?php
if (!function_exists('themename_button_section_button')) {
    function themename_button_section_button($widget)
    {
        $widget->add_responsive_control(
            'icon_font_size',
            [
				'label' => esc_html__( 'Icon Font Size', 'themename' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );



		$widget->start_controls_tabs('tabs_button_icon_style');

		$widget->start_controls_tab(
			'tab_button_icon_style',
			[
				'label' => esc_html__('Normal', 'themename'),
			]
		);

		$widget->add_control(
			'tab_button_icon_color',
			[
				'label' => esc_html__('Icon Color', 'themename'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);


		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'tab_button_icon_style_hover',
			[
				'label' => esc_html__('Hover', 'themename'),
			]
		);

		$widget->add_control(
			'tab_button_icon_color_hover',
			[
				'label' => esc_html__('Icon Color', 'themename'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover .elementor-button-icon, {{WRAPPER}} .elementor-button:focus .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover .elementor-button-icon svg, {{WRAPPER}} .elementor-button:focus .elementor-button-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();
    } 

    add_action('elementor/element/button/section_style/before_section_end', 'themename_button_section_button', 10, 2);
}