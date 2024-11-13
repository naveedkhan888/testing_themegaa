<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;


$default_color = themename_tbay_default_theme_primary_color();
$default_fonts = themename_tbay_default_theme_primary_fonts();

if ( !isset($default_color['main_color_second']) ) {
	$default_color['main_color_second'] = '';
}

if ( !isset($default_fonts['main_font_second']) ) {
	$default_fonts['main_font_second'] = '';
}

/** Style Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-format-color-text',
        'title' => esc_html__('Style', 'themename'),
	)
);

if (!function_exists('themename_settings_style_main_fields')) {
    function themename_settings_style_main_fields( $default_color )
    {

		$fields_color_text = $fields_color_sencond_text = array();
		$btn_text_color = ( !empty($default_color['btn_text_color']) ) ? $default_color['btn_text_color'] : '';
        $fields = array(
			array(
				'id'       => 'boby_bg',
				'type'     => 'background',
				'output'   => array( 'body' ),
				'title'    => esc_html__('Body Background', 'themename'),
				'subtitle' => esc_html__('Body background with image, color, etc.', 'themename'),
			),
			array(
				'title' => esc_html__('Theme Main Color', 'themename'),
				'id' => 'main_color',
				'type' => 'color',
				'transparent' => false,
				'default' => $default_color['main_color'],
			),
			array(
				'title' => esc_html__('Color Text of the button theme color', 'themename'),
				'id' => 'btn_text_color',
				'type' => 'color',
				'transparent' => false,
				'default' => $btn_text_color,
			)
        );

		if( !empty($default_color['enable_main_color_text']) && $default_color['enable_main_color_text'] ) {
            $fields_color_text = array(
				array(
					'title' => esc_html__('Theme Main Color (Text)', 'themename'),
					'id' => 'main_color_text',
					'type' => 'color',
					'transparent' => false,
					'default' => $default_color['main_color_text'],
				),
            );
		}

		if( !empty($default_color['enable_main_color_second']) && $default_color['enable_main_color_second'] ) {
            $fields_color_sencond_text = array(
				array(
					'title' => esc_html__('Theme Main Color Second', 'themename'),
					'id' => 'main_color_second',
					'type' => 'color',
					'transparent' => false,
					'default' => $default_color['main_color_second'],
				),
            );
		}

		$fields = array_merge($fields, $fields_color_text, $fields_color_sencond_text);

		return $fields;
	}
}


// Style main color settings
Redux::set_section(
	$opt_name,
	array(
		'title' => esc_html__('Main', 'themename'),
		'subsection' => true,
		'fields' => themename_settings_style_main_fields( $default_color )
	)
);


// Style Typography settings
Redux::set_section(
	$opt_name,
	array(
		'subsection' => true,
		'title' => esc_html__('Typography', 'themename'),
		'fields' => array(
			array(
				'id' => 'show_typography',
				'type' => 'switch',
				'title' => esc_html__('Edit Typography', 'themename'),
				'default' => false
			),
			array(
				'title'    => esc_html__('Font Source', 'themename'),
				'id'       => 'font_source',
				'type'     => 'radio',
				'required' => array('show_typography','=', true),
				'options'  => array(
					'1' => 'Standard + Google Webfonts',
					'2' => 'Google Custom',
					'3' => 'Custom Fonts'
				),
				'default' => '1'
			),
			array(
				'id'=>'font_google_code',
				'type' => 'text',
				'title' => esc_html__('Google Link', 'themename'),
				'subtitle' => '<em>'.esc_html__('Paste the provided Google Code', 'themename').'</em>',
				'default' => '',
				'desc' => esc_html__('e.g.: https://fonts.googleapis.com/css?family=Open+Sans', 'themename'),
				'required' => array('font_source','=','2')
			),

			array(
				'id' => 'main_custom_font_info',
				'icon' => true,
				'type' => 'info',
				'raw' => '<h3 style="margin: 0;">'. sprintf(
					'%1$s <a href="%2$s">%3$s</a>',
					esc_html__('Video guide custom font in ', 'themename'),
					esc_url('https://www.youtube.com/watch?v=ljXAxueAQUc'),
					esc_html__('here', 'themename')
				) .'</h3>',
				'required' => array('font_source','=','3')
			),

			array(
				'id' => 'main_font_info',
				'icon' => true,
				'type' => 'info',
				'raw' => '<h3 style="margin: 0;"> '.esc_html__('Main Font', 'themename').'</h3>',
				'required' => array('show_typography','=', true),
			),

			// Standard + Google Webfonts
			array(
				'title' => esc_html__('Font Face', 'themename'),
				'id' => 'main_font',
				'type' => 'typography',
				'line-height' => false,
				'text-align' => false,
				'font-style' => false,
				'font-weight' => false,
				'all_styles'=> true,
				'font-size' => false,
				'color' => false,
				'default' => array(
					'font-family' => '',
					'subsets' => '',
				),
				'required' => array(
					array('font_source','=','1'),
					array('show_typography','=', true)
				)
			),
			
			// Google Custom
			array(
				'title' => esc_html__('Google Font Face', 'themename'),
				'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'themename').'</em>',
				'desc' => esc_html__('e.g.: &#39;Open Sans&#39;', 'themename'),
				'id' => 'main_google_font_face',
				'type' => 'text',
				'default' => '',
				'required' => array(
					array('font_source','=','2'),
					array('show_typography','=', true)
				)
			),

			// main Custom fonts
			array(
				'title' => esc_html__('Main custom Font Face', 'themename'),
				'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'themename').'</em>',
				'desc' => esc_html__('e.g.: &#39;Open Sans&#39;', 'themename'),
				'id' => 'main_custom_font_face',
				'type' => 'text',
				'default' => '',
				'required' => array(
					array('font_source','=','3'),
					array('show_typography','=', true)
				)
			),

			array (
				'id' => 'main_font_second_info',
				'icon' => true,
				'type' => 'info',
				'raw' => '<h3 style="margin: 0;"> '.esc_html__('Font Second', 'themename').'</h3>',
				'required' => array( 
					array('show_typography','=', true),
					array('show_typography','=', $default_fonts['main_font_second']),
				)
			),

			// Standard + Google Webfonts
			array (
				'title' => esc_html__('Font Face Second', 'themename'),
				'id' => 'main_font_second',
				'type' => 'typography',
				'line-height' => false,
				'text-align' => false,
				'font-style' => false,
				'font-weight' => false,
				'all_styles'=> true,
				'font-size' => false,
				'color' => false,
				'default' => array (
					'font-family' => '',
					'subsets' => '',
				),
				'required' => array( 
					array('font_source','=','1'), 
					array('show_typography','=', true),
					array('show_typography','=', $default_fonts['font_second_enable']),
				)
			),

			// Google Custom                        
			array (
				'title' => esc_html__('Google Font Face Second', 'themename'),
				'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'themename').'</em>',
				'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'themename'),
				'id' => 'main_second_google_font_face',
				'type' => 'text',
				'default' => '',
				'required' => array( 
					array('font_source','=','2'), 
					array('show_typography','=', true),
					array('show_typography','=', $default_fonts['font_second_enable']),
				)
			),                    

			// main Custom fonts                      
			array (
				'title' => esc_html__('Custom Font Face Second', 'themename'),
				'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'themename').'</em>',
				'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'themename'),
				'id' => 'main_second_custom_font_face',
				'type' => 'text',
				'default' => '',
				'required' => array( 
					array('font_source','=','3'), 
					array('show_typography','=', true),
					array('show_typography','=', $default_fonts['font_second_enable']),
				)
			),
		)
	)
);


// Style Header Mobile settings
Redux::set_section(
	$opt_name,
	array(
		'title' => esc_html__('Header Mobile', 'themename'),
		'subsection' => true,
		'fields' => array(

			array(
				'title' => esc_html__('Background Color', 'themename'),
				'id' => 'header_mobile_bg',
				'type' => 'color',
				'transparent' => false,
			),

			array(
				'title' => esc_html__('Header Color', 'themename'),
				'id' => 'header_mobile_color',
				'type' => 'color',
				'transparent' => false,
			),
		)
	)
);