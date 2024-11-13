<?php
if (!function_exists('themename_register_page_meta_boxes')) {
    add_filter( 'rwmb_meta_boxes', 'themename_register_page_meta_boxes' );
    function themename_register_page_meta_boxes( $meta_boxes ) {
        $sidebars = themename_sidebars_array();

        $footers = array_merge(array('global' => esc_html__('Global Setting', 'themename')), themename_tbay_get_footer_layouts());
        $headers = array_merge(array('global' => esc_html__('Global Setting', 'themename')), themename_tbay_get_header_layouts());

        $prefix = 'tbay_page_';

        $fields = array(
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'themename'),
                'description' => esc_html__('Choose a header for your website.', 'themename'),
                'options' => $headers,
                'std' => 'global'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'themename'),
                'description' => esc_html__('Choose a footer for your website.', 'themename'),
                'options' => $footers,
                'std' => 'global'
            ),
            array(
                'id' => $prefix.'hide_title',
                'type'      => 'switch',
                'style'     => 'rounded',            
                'name' => esc_html__('Hide Title?', 'themename'),
                'on_label'  => 'Yes',
                'off_label' => 'No',
                'std' => true,
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type'      => 'switch',
                'style'     => 'rounded',            
                'name' => esc_html__('Show Breadcrumb?', 'themename'),
                'on_label'  => 'Yes',
                'off_label' => 'No',
                'std' => false,
            ),
            array(
                'name' => esc_html__('Breadcrumbs Text Alignment', 'themename'),
                'id'   => $prefix.'breadcrumbs_text_alignment',
                'type' => 'select',
                'visible' => array( $prefix.'show_breadcrumb', '=', true ),
				'options'  => array(
					'left' => esc_html__('Text Left', 'themename'),
					'center' => esc_html__('Text Center', 'themename'),
					'right' => esc_html__('Text Right', 'themename'),
				),
                'std' => 'center',
            ),
            array(
                'name' => esc_html__('Select Breadcrumbs Layout', 'themename'),
                'id'   => $prefix.'breadcrumbs_layout',
                'type' => 'radio',
                'visible' => array( $prefix.'show_breadcrumb', '=', true ),
                'options' => array(
                    'image' => esc_html__('Background Image', 'themename'),
                    'color' => esc_html__('Background color', 'themename'),
                    'text' => esc_html__('Just text', 'themename')
                ),
                'std' => 'text',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'color',
                'visible' => array( $prefix.'breadcrumbs_layout', '=', 'color' ),
                'name' => esc_html__('Breadcrumb Background Color', 'themename')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',  
                'type' => 'single_image',
                'visible' => array( $prefix.'breadcrumbs_layout', '=', 'image' ),
                'name' => esc_html__('Breadcrumb Background Image', 'themename')
            ),
            array(
                'name' => esc_html__('Select Layout', 'themename'),
                'id'   => $prefix.'layout',
                'type' => 'select',
                'options' => array(
                    'main' => esc_html__('Main Content Only', 'themename'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'themename'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'themename'),
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'themename'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'themename'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'themename'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'themename')
            )
        );

        $meta_boxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Display Settings', 'themename'),
            'post_types'                => ['page'],
            'context'                   => 'normal',
            'priority'                  => 'high',
            'autosave'                  => true,
            'fields'                    => $fields
        );

        return $meta_boxes;
    }
}