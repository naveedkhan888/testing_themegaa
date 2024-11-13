<?php if (! defined('LASA_THEME_DIR')) {
    exit('No direct script access allowed');
}
/**
 * Lasa woocommerce Template Hooks
 *
 * Action/filter hooks used for Lasa woocommerce functions/templates.
 *
 */


/**
 * Lasa Header Mobile Content.
 *
 * @see lasa_the_button_mobile_menu()
 * @see lasa_the_logo_mobile()
 */
add_action('lasa_header_mobile_content', 'lasa_the_button_mobile_menu', 5);
add_action('lasa_header_mobile_content', 'lasa_the_icon_home_page_mobile', 10);
add_action('lasa_header_mobile_content', 'lasa_the_logo_mobile', 15);
add_action('lasa_header_mobile_content', 'lasa_the_icon_mini_cart_header_mobile', 20);


/**
 * Lasa Header Mobile before content
 *
 * @see lasa_the_hook_header_mobile_all_page
 */
add_action('lasa_before_header_mobile', 'lasa_the_hook_header_mobile_all_page', 5);

/**Page Cart**/
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
