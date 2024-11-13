<?php
if (!function_exists('themename_customize_section_accordion')) {
    function themename_customize_section_accordion($widget)
    {
		$widget->add_responsive_control(
            'accordion_style_align',
            [
                'label' => esc_html__('Alignment', 'themename'),
                'type' => Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('left', 'themename'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('center', 'themename'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('right', 'themename'),
                        'icon' => 'fa fa-align-right',
                    ],
                ], 
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion-item' => 'text-align: {{VALUE}}',
                ],
            ]
        ); 
    } 
    add_action('elementor/element/accordion/section_title_style/before_section_end', 'themename_customize_section_accordion', 10, 2);
}


if (!function_exists('themename_customize_section_accordion_icon')) {
    function themename_customize_section_accordion_icon($widget)
    {
		$widget->add_responsive_control(
            'accordion_style_icon_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'themename' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );   
		
		$widget->add_control(
			'accordion_style_font_size',
			[
				'label' => esc_html__( 'Font Size', 'themename' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 4,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

    } 
    add_action('elementor/element/accordion/section_toggle_style_icon/before_section_end', 'themename_customize_section_accordion_icon', 10, 2);
}

if (!function_exists('themename_customize_section_accordion_content')) {
    function themename_customize_section_accordion_content($widget)
    {
		$widget->add_responsive_control(
			'accordion_style_content_spacing',
			[
				'label' => esc_html__( 'Spacing', 'themename' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion-item .elementor-tab-content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
    } 
    add_action('elementor/element/accordion/section_toggle_style_content/before_section_end', 'themename_customize_section_accordion_content', 10, 2);
}