<?php
if (!function_exists('lasa_register_portfolio_meta_boxes')) {
    add_filter( 'rwmb_meta_boxes', 'lasa_register_portfolio_meta_boxes' );
    function lasa_register_portfolio_meta_boxes( $meta_boxes ) {
        $prefix = 'tbay_portfolio_';

        $fields = array(
            array(
                'id' => $prefix.'author',
                'type' => 'text',
                'name' => esc_html__('Author', 'lasa'),
            ),
            array(
                'id' => $prefix.'client_name',
                'type' => 'text',
                'name' => esc_html__('Client Name', 'lasa'),
            ),
            array(
                'id' => $prefix.'skills',
                'type' => 'text',
                'name' => esc_html__('Skills', 'lasa'),
            ),
            array(
                'id' => $prefix.'project_url',
                'type' => 'url',
                'name' => esc_html__('Project Url', 'lasa'),
            ),
            array(
                'id' => $prefix.'date',
                'type' => 'date',
                'name' => esc_html__('Date', 'lasa'),
            ),
            array(
                'id' => $prefix.'short_description',
                'type' => 'textarea',
                'name' => esc_html__('Short Description', 'lasa'),
            ),
            array(
                'id' => $prefix.'gallery_image',
                'type' => 'image_advanced',
                'name' => esc_html__('Gallery Image', 'lasa'),
            ),
        );

        $meta_boxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Portfolio Details', 'lasa'),
            'post_types'                => ['tb_portfolio'],
            'context'                   => 'normal',
            'priority'                  => 'high',
            'autosave'                  => true,
            'fields'                    => $fields
        );

        return $meta_boxes;
    }
}