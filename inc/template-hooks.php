<?php if (! defined('THEMENAME_THEME_DIR')) {
    exit('No direct script access allowed');
}
/**
 * Themename woocommerce Template Hooks
 *
 * Action/filter hooks used for Themename woocommerce functions/templates.
 *
 */


/**
 * Themename Header Mobile Content.
 *
 * @see themename_the_button_mobile_menu()
 * @see themename_the_logo_mobile()
 */
add_action('themename_header_mobile_content', 'themename_the_button_mobile_menu', 5);
add_action('themename_header_mobile_content', 'themename_the_icon_home_page_mobile', 10);
add_action('themename_header_mobile_content', 'themename_the_logo_mobile', 15);
add_action('themename_header_mobile_content', 'themename_the_icon_mini_cart_header_mobile', 20);


/**
 * Themename Header Mobile before content
 *
 * @see themename_the_hook_header_mobile_all_page
 */
add_action('themename_before_header_mobile', 'themename_the_hook_header_mobile_all_page', 5);

/**Page Cart**/
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
