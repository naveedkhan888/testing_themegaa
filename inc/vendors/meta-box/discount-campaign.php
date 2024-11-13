<?php
if ( !function_exists('lasa_register_discount_campaign_meta_boxes') ) {
    add_filter( 'rwmb_meta_boxes', 'lasa_register_discount_campaign_meta_boxes' );
    function lasa_register_discount_campaign_meta_boxes($meta_boxes)
    {
        if( !class_exists( 'Tbay_PostType_Discount_Campaign' ) ) return $meta_boxes;

        $prefix = 'tbay_discount_campaign_';
        
        $meta_boxes[$prefix . 'format_setting'] = array(
            'id'                        => 'post_discount_campaig_post_meta',
            'title'                     => esc_html__('Campaign Setting', 'lasa'),
            'post_types'                => array( 'tb_discount_campaign' ),
            'fields'     => array(
                array(
                    'id'          => $prefix.'group',
                    'type'        => 'group',
                    'clone'       => true,
                    'ajax'        => true,
                    'sort_clone' => true,
                    'group_title' => array( 'field' => 'tbay_discount_campaign_sale_product' ), // ID of the subfield
                    'fields' => array(
                        array(
                            'id'                => 'product_sale_item',
                            'name'              => esc_html__('Select product sale', 'lasa'),
                            'type'              => 'post',
                            'ajax'              => true,
                            'query_args'        => lasa_get_on_sale_query_args(),
                            'placeholder'       => esc_html__('Select a product', 'lasa'),
                        ),
                    ),
                ),
            ),
        );
        

        return $meta_boxes;
    }
}

if ( !function_exists('lasa_rem_editor_from_post_type') ) {
    add_action('admin_init', 'lasa_rem_editor_from_post_type');
    function lasa_rem_editor_from_post_type() {
        if( !class_exists( 'Tbay_PostType_Discount_Campaign' ) ) return;

        remove_post_type_support( 'tb_discount_campaign', 'editor' );
    }
}