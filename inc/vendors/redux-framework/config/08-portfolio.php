<?php
/**
 * Redux Framework checkbox config.
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;


/** Page 404 Settings **/
Redux::set_section(
	$opt_name,
	array(
        'icon' => 'zmdi zmdi-case',
        'title' => esc_html__('Portfolio', 'lasa'),
        'fields' => array(
            array(
				'id'       => 'page_portfolio',
				'type'     => 'select',
				'data'     => 'pages',
				'title'    => esc_html__( 'Select Page Portfolio', 'lasa' ),
			),
        )
	)
);