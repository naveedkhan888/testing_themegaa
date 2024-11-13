<?php
if (!function_exists('themename_heading_section_title_style')) {
    function themename_heading_section_title_style($widget)
    {
        $widget->add_control(
            'enable_title_background_text',
            [
                'label'   => esc_html__('Enable Background Text', 'themename'),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'show-title-bg-text-',
				'description' => esc_html__( 'When you enable this option, the text color will not receive it, it will change to the background text below', 'themename' ),
                'default' => '',
            ]
        );

		$widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'text_box_title_background',
                'condition' => [
                    'enable_title_background_text' => 'yes'
                ],
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );
    } 

    add_action('elementor/element/heading/section_title_style/before_section_end', 'themename_heading_section_title_style', 10, 2);
}