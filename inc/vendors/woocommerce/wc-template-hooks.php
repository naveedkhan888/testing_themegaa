<?php

// Remove default breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'themename_tbay_woocommerce_breadcrumb_defaults');
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('themename_woo_template_main_wrapper_before', 'woocommerce_breadcrumb', 20);



// Remove Default Sidebars
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);



/**
 * Product Add to cart.
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 * @see woocommerce_single_variation()
 * @see woocommerce_single_variation_add_to_cart_button()
 */
// add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); 
add_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
add_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
add_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
add_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
add_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
add_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);

add_action('woocommerce_single_product_summary', 'themename_woo_get_subtitle', 5);

add_action('woocommerce_after_add_to_cart_form', 'themename_product_popup_group_buttons', 35);

/*Add custom html before, after button add to cart*/
add_action('woocommerce_before_add_to_cart_form', 'themename_html_before_add_to_cart_button', 10, 0);
add_action('woocommerce_after_add_to_cart_form', 'themename_html_after_add_to_cart_button', 99);

/*Add custom html before, after inner product summary*/
add_action('woocommerce_single_product_summary', 'themename_html_before_inner_product_summary', 1, 0);
add_action('woocommerce_single_product_summary', 'themename_html_after_inner_product_summary', 99);
add_action('themename_woocommerce_single_product_summary_left', 'themename_html_after_inner_product_summary', 99);

add_action('woocommerce_before_single_product', 'themename_html_before_product_summary', 5);
add_action('woocommerce_after_single_product', 'themename_html_after_product_summary', 5);

/**
 * Product Vertical
 *
 * @see woocommerce_after_shop_loop_item_vertical_title()
 */


add_action('woocommerce_after_shop_loop_item_vertical_title', 'woocommerce_template_loop_rating', 15);
add_action('woocommerce_after_shop_loop_item_vertical_title', 'woocommerce_template_loop_price', 10);


/**
 * Product Grid
 *
 */
add_action('themename_woocommerce_group_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10, 1);

// Product Landing Page

add_action('themename_add_to_cart_landing_page', 'woocommerce_template_loop_add_to_cart', 10, 1);

/**
 * Product List
 * themename_woocommerce_group_buttons_list
 *
 */
add_action('themename_woocommerce_group_buttons_list', 'themename_the_quick_view', 10, 1);
add_action('themename_woocommerce_group_buttons_list', 'themename_the_yith_compare', 20, 1);
add_action('themename_woocommerce_group_buttons_list', 'themename_the_yith_wishlist', 30, 1);
add_action('themename_woocommerce_group_buttons_list', 'woocommerce_template_loop_add_to_cart', 40, 1);


/**
 * Product List
 *
 */



add_action('themename_woo_list_right', 'themename_the_product_name', 10);
add_action('themename_woo_list_right', 'woocommerce_template_loop_price', 20);
add_action('themename_woo_list_right', 'woocommerce_template_loop_rating', 30);
add_action('themename_woocommerce_before_shop_list_item', 'themename_woocommerce_add_quantity_mode_list', 5);


/**Fix duppitor image on elementor pro **/
if ( ! function_exists( 'themename_remove_shop_loop_item_title' ) ) {
    add_action( 'themename_content_product_item_before', 'themename_remove_shop_loop_item_title', 10 ); 
    function themename_remove_shop_loop_item_title() {
        //Change postition label sale
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    }
}