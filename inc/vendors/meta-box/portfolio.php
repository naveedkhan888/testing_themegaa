<?php
if (!function_exists('themename_register_portfolio_meta_boxes')) {
    add_filter( 'rwmb_meta_boxes', 'themename_register_portfolio_meta_boxes' );
    function themename_register_portfolio_meta_boxes( $meta_boxes ) {
        $prefix = 'xptheme_portfolio_';

        $fields = array(
            array(
                'id' => $prefix.'author',
                'type' => 'text',
                'name' => esc_html__('Author', 'themename'),
            ),
            array(
                'id' => $prefix.'client_name',
                'type' => 'text',
                'name' => esc_html__('Client Name', 'themename'),
            ),
            array(
                'id' => $prefix.'skills',
                'type' => 'text',
                'name' => esc_html__('Skills', 'themename'),
            ),
            array(
                'id' => $prefix.'project_url',
                'type' => 'url',
                'name' => esc_html__('Project Url', 'themename'),
            ),
            array(
                'id' => $prefix.'date',
                'type' => 'date',
                'name' => esc_html__('Date', 'themename'),
            ),
            array(
                'id' => $prefix.'short_description',
                'type' => 'textarea',
                'name' => esc_html__('Short Description', 'themename'),
            ),
            array(
                'id' => $prefix.'gallery_image',
                'type' => 'image_advanced',
                'name' => esc_html__('Gallery Image', 'themename'),
            ),
        );

        $meta_boxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Portfolio Details', 'themename'),
            'post_types'                => ['tb_portfolio'],
            'context'                   => 'normal',
            'priority'                  => 'high',
            'autosave'                  => true,
            'fields'                    => $fields
        );

        return $meta_boxes;
    }
}