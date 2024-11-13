<?php
if (!function_exists('lasa_register_page_meta_boxes')) {
    add_filter( 'rwmb_meta_boxes', 'lasa_register_page_meta_boxes' );
    function lasa_register_page_meta_boxes( $meta_boxes ) {
        $sidebars = lasa_sidebars_array();

        $footers = array_merge(array('global' => esc_html__('Global Setting', 'lasa')), lasa_tbay_get_footer_layouts());
        $headers = array_merge(array('global' => esc_html__('Global Setting', 'lasa')), lasa_tbay_get_header_layouts());

        $prefix = 'tbay_page_';

        $fields = array(
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'lasa'),
                'description' => esc_html__('Choose a header for your website.', 'lasa'),
                'options' => $headers,
                'std' => 'global'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'lasa'),
                'description' => esc_html__('Choose a footer for your website.', 'lasa'),
                'options' => $footers,
                'std' => 'global'
            ),
            array(
                'id' => $prefix.'hide_title',
                'type'      => 'switch',
                'style'     => 'rounded',            
                'name' => esc_html__('Hide Title?', 'lasa'),
                'on_label'  => 'Yes',
                'off_label' => 'No',
                'std' => true,
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type'      => 'switch',
                'style'     => 'rounded',            
                'name' => esc_html__('Show Breadcrumb?', 'lasa'),
                'on_label'  => 'Yes',
                'off_label' => 'No',
                'std' => false,
            ),
            array(
                'name' => esc_html__('Breadcrumbs Text Alignment', 'lasa'),
                'id'   => $prefix.'breadcrumbs_text_alignment',
                'type' => 'select',
                'visible' => array( $prefix.'show_breadcrumb', '=', true ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'lasa'),
					'center' => esc_html__('Text Center', 'lasa'),
					'right' => esc_html__('Text Right', 'lasa'),
				),
                'std' => 'center',
            ),
            array(
                'name' => esc_html__('Select Breadcrumbs Layout', 'lasa'),
                'id'   => $prefix.'breadcrumbs_layout',
                'type' => 'radio',
                'visible' => array( $prefix.'show_breadcrumb', '=', true ),
                'options' => array(
                    'image' => esc_html__('Background Image', 'lasa'),
                    'color' => esc_html__('Background color', 'lasa'),
                    'text' => esc_html__('Just text', 'lasa')
                ),
                'std' => 'text',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'color',
                'visible' => array( $prefix.'breadcrumbs_layout', '=', 'color' ),
                'name' => esc_html__('Breadcrumb Background Color', 'lasa')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',  
                'type' => 'single_image',
                'visible' => array( $prefix.'breadcrumbs_layout', '=', 'image' ),
                'name' => esc_html__('Breadcrumb Background Image', 'lasa')
            ),
            array(
                'name' => esc_html__('Select Layout', 'lasa'),
                'id'   => $prefix.'layout',
                'type' => 'select',
                'options' => array(
                    'main' => esc_html__('Main Content Only', 'lasa'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'lasa'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'lasa'),
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'lasa'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'lasa'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'lasa'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'lasa')
            )
        );

        $meta_boxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Display Settings', 'lasa'),
            'post_types'                => ['page'],
            'context'                   => 'normal',
            'priority'                  => 'high',
            'autosave'                  => true,
            'fields'                    => $fields
        );

        return $meta_boxes;
    }
}