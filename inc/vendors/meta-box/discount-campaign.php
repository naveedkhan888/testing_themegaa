<?php
if ( !function_exists('themename_register_discount_campaign_meta_boxes') ) {
    add_filter( 'rwmb_meta_boxes', 'themename_register_discount_campaign_meta_boxes' );
    function themename_register_discount_campaign_meta_boxes($meta_boxes)
    {
        if( !class_exists( 'Xptheme_PostType_Discount_Campaign' ) ) return $meta_boxes;

        $prefix = 'xptheme_discount_campaign_';
        
        $meta_boxes[$prefix . 'format_setting'] = array(
            'id'                        => 'post_discount_campaig_post_meta',
            'title'                     => esc_html__('Campaign Setting', 'themename'),
            'post_types'                => array( 'tb_discount_campaign' ),
            'fields'     => array(
                array(
                    'id'          => $prefix.'group',
                    'type'        => 'group',
                    'clone'       => true,
                    'ajax'        => true,
                    'sort_clone'  => true,
                    'group_title' => array( 'field' => 'xptheme_discount_campaign_sale_product' ), // ID of the subfield
                    'fields' => array(
                        array(
                            'id'                => 'product_sale_item',
                            'name'              => esc_html__('Select product sale', 'themename'),
                            'type'              => 'post',
                            'post_type'         => 'product', // Ensures the field queries WooCommerce products
                            'ajax'              => true,
                            'query_args'        => themename_get_on_sale_query_args(), // Fetches sale products
                            'placeholder'       => esc_html__('Select a product', 'themename'),
                        ),
                    ),
                ),
            ),
        );

        return $meta_boxes;
    }
}

if ( !function_exists('themename_get_on_sale_query_args') ) {
    function themename_get_on_sale_query_args() {
        return array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_sale_price', // Sale price meta key
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ),
            ),
        );
    }
}

if ( !function_exists('themename_rem_editor_from_post_type') ) {
    add_action('admin_init', 'themename_rem_editor_from_post_type');
    function themename_rem_editor_from_post_type() {
        if( !class_exists( 'Xptheme_PostType_Discount_Campaign' ) ) return;

        remove_post_type_support( 'tb_discount_campaign', 'editor' );
    }
}

// Debugging Output (Optional)
add_action( 'init', function() {
    $query = new WP_Query( themename_get_on_sale_query_args() );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            error_log( 'Product Found: ' . get_the_title() ); // Logs product titles
        }
    } else {
        error_log( 'No products found on sale' );
    }
    wp_reset_postdata();
});
