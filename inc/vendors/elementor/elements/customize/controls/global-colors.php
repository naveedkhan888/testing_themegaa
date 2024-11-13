<?php
if (!function_exists('lasa_settings_global_colors_advanced')) {
    function lasa_settings_global_colors_advanced($widget, $args)
    {
		$default_colors_primary = [
			[
				'_id' => 'primary',
				'title' => esc_html__( 'Primary', 'lasa' ),
				'color' => '#cc0000',
			],
		];

		$default_colors_secondary = [
			[
				'_id' => 'secondary',
				'title' => esc_html__( 'Secondary', 'lasa' ),
				'color' => '#CA6D6F',
			],
		];

		$default_colors = [
			[
				'_id' => 'text',
				'title' => esc_html__( 'Text', 'lasa' ),
				'color' => '#121216',
			],
			[
				'_id' => 'accent',
				'title' => esc_html__( 'Border', 'lasa' ),
				'color' => '#DDDDDD',
			],
		];


		$default_colors = array_merge($default_colors_primary, $default_colors_secondary, $default_colors);

        $widget->update_control(
            'system_colors',
            [
                'default' => $default_colors,
            ] 
        );
    }

    add_action('elementor/element/kit/section_global_colors/before_section_end', 'lasa_settings_global_colors_advanced', 10, 2);
}