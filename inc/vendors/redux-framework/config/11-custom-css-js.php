<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;


/** Custom CSS/JS Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-code-setting',
        'title' => esc_html__('Custom CSS/JS', 'themename'),
	)
);

Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Custom CSS', 'themename'),
        'fields' => array(
            array(
                'title' => esc_html__('Global Custom CSS', 'themename'),
                'id' => 'custom_css',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for desktop', 'themename'),
                'id' => 'css_desktop',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for tablet', 'themename'),
                'id' => 'css_tablet',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for mobile landscape', 'themename'),
                'id' => 'css_wide_mobile',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            array(
                'title' => esc_html__('Custom CSS for mobile', 'themename'),
                'id' => 'css_mobile',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
        )
	)
);

Redux::set_section(
	$opt_name,
	array(
        'subsection' => true,
        'title' => esc_html__('Custom Js', 'themename'),
        'fields' => array(
            array(
                'title' => esc_html__('Header JavaScript Code', 'themename'),
                'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'themename').'<em>',
                'id' => 'header_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
            
            array(
                'title' => esc_html__('Footer JavaScript Code', 'themename'),
                'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'themename').'<em>',
                'id' => 'footer_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
        )
	)
);