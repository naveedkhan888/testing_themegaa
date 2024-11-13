<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** Footer Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-border-bottom',
        'title' => esc_html__('Footer', 'themename'),
        'fields' => array(
            array(
                'id' => 'footer_type',
                'type' => 'select',
                'title' => esc_html__('Select Footer Layout', 'themename'),
                'options' => themename_tbay_get_footer_layouts(),
                'default' => 'footer_default'
            ),
            array(
                'id' => 'copyright_text',
                'type' => 'editor',
                'title' => esc_html__('Copyright Text', 'themename'),
                'default' => esc_html__('Copyright  &#64; 2024 Themename Designed by XpertTheme. All Rights Reserved.', 'themename'),
                'required' => array('footer_type','=','footer_default')
            ),
            array(
                'id' => 'back_to_top',
                'type' => 'switch',
                'title' => esc_html__('Enable "Back to Top" Button', 'themename'),
                'default' => true,
            ),
        )
	)
);