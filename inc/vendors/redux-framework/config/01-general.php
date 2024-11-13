<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

/** General Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-settings',
        'title' => esc_html__('General', 'lasa'),
        'fields' => array(
            array(
                'id'            => 'config_media',
                'type'          => 'switch',
                'title'         => esc_html__('Enable Config Image Size', 'lasa'),
                'subtitle'      => esc_html__('Config image size in WooCommerce and Media Setting', 'lasa'),
                'default'       => false
            ),
            array(
                'id' => 'ajax_dropdown_megamenu',
                'type' => 'switch',
                'title' => esc_html__('Enable "Ajax Dropdown" Mega Menu', 'lasa'),
                'default' => false,
            ),
        )
	)
);